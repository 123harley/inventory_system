<?php
include('db.php'); // Include the database connection

// Initialize a variable for search term
$search_term = '';

// Check if the search form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        // Get the search term from the form
        $search_term = $_POST['search_term'];
        // Search query
        $query = "SELECT * FROM sub_inventory WHERE item_name LIKE ?";
        $stmt = $conn->prepare($query);
        $search_term_param = "%" . $search_term . "%";
        $stmt->bind_param("s", $search_term_param);
        $stmt->execute();
        $result = $stmt->get_result();
    } elseif (isset($_POST['add_item'])) {
        // Add item to the inventory
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];

        // Use prepared statement to prevent SQL injection
        $check_query = $conn->prepare("SELECT * FROM sub_inventory WHERE item_name = ?");
        $check_query->bind_param("s", $item_name);
        $check_query->execute();
        $result = $check_query->get_result();

        if ($result->num_rows > 0) {
            // Item exists, update the quantity
            $update_query = $conn->prepare("UPDATE sub_inventory SET quantity = quantity + ? WHERE item_name = ?");
            $update_query->bind_param("is", $quantity, $item_name);
            $update_query->execute();
        } else {
            // Item doesn't exist, insert a new record
            $insert_query = $conn->prepare("INSERT INTO sub_inventory (item_name, quantity) VALUES (?, ?)");
            $insert_query->bind_param("si", $item_name, $quantity);
            $insert_query->execute();
        }
    } elseif (isset($_POST['pull_item'])) {
        // Pull item from inventory
        $item_name = $_POST['item_name'];
        $quantity = $_POST['quantity'];

        // Use prepared statement to prevent SQL injection
        $check_query = $conn->prepare("SELECT * FROM sub_inventory WHERE item_name = ?");
        $check_query->bind_param("s", $item_name);
        $check_query->execute();
        $result = $check_query->get_result();

        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
            $current_quantity = $item['quantity'];

            if ($current_quantity >= $quantity) {
                // There is enough stock, update the quantity
                $update_query = $conn->prepare("UPDATE sub_inventory SET quantity = quantity - ? WHERE item_name = ?");
                $update_query->bind_param("is", $quantity, $item_name);
                $update_query->execute();
            } else {
                echo "<div class='alert error'>Not enough stock for $item_name.</div>";
            }
        } else {
            echo "<div class='alert error'>Item not found in inventory.</div>";
        }
    } else {
        // Default query if no search is made
        $query = "SELECT * FROM sub_inventory";
        $result = $conn->query($query);
    }
}

// If no search is performed, show all items
if ($search_term == '') {
    $query = "SELECT * FROM sub_inventory";
    $result = $conn->query($query);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(13, 104, 240);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        h3 {
            color: #007BFF;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }

        .inventory-list {
            margin-top: 30px;
        }

        /* Back Button Style */
        .back-button {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Back Button -->
    <a href="main.php"><button class="back-button">Back</button></a>

    <h2>Inventory Management</h2>
    <br>
    <br>
    <a href="sub_inventory.php"><button class="back-button">refresh</button></a>

    <!-- Search Form -->
    <div class="search-form">
        <h3>Search Item</h3>
        <form method="POST">
            <input type="text" name="search_term" placeholder="Search.." value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit" name="search">Search</button>
        </form>
    </div>

    <!-- Form for adding items -->
    <div class="add-item">
        <h3>Add Item</h3>
        <form method="POST">
            <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" id="item_name" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br>

            <button type="submit" name="add_item">Add Item</button>
        </form>
    </div>

    <!-- Form for pulling out items -->
    <div class="pull-item">
        <h3>Pull Item</h3>
        <form method="POST">
            <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" id="item_name" required><br>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br>

            <button type="submit" name="pull_item">Pull Item</button>
        </form>
    </div>

    <!-- Inventory List -->
    <div class="inventory-list">
        <h3>Inventory List</h3>
        <table>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['item_name'] . "</td><td>" . $row['quantity'] . "</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>

<?php
$conn->close(); // Close the connection
?>
