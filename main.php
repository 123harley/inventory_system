<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Style */
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(19, 106, 236);
            color: #333;
            padding-top: 80px; /* Adjusted for fixed navbar */
        }

        /* Header */
        header {
            background-color: #1877f2;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 24px;
        }

        /* Main Container */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
        }

        /* Form Styles */
        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #1877f2;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #165eaf;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f4f6f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Search Bar */
        .search-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            width: 300px;
            margin-right: 10px;
        }

        /* Action Buttons */
        .actions form {
            display: inline-block;
            margin-right: 10px;
        }

        .refresh-btn {
        background-color: #4CAF50; /* Green button */
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }

    .refresh-btn:hover {
        background-color: #45a049; /* Darker green on hover */
    }

    .refresh-btn:active {
        background-color: #3e8e41; /* Even darker green when clicked */
    }

    .refresh-btn:focus {
        outline: none; /* Remove focus outline */
    }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Inventory Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_supplier.php">Add Supplier</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Others...
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="inventory_transactions.php">Inventory Transactions</a></li>
                            <li><a class="dropdown-item" href="products.php">Products</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="sub_inventory.php">Items</a></li>
                            <li><a class="dropdown-item" href="logout.php">logout</a></li>
                        </ul>
                    </li>
                </ul>
                <form method="GET" action="">
        <input type="text" id="search" name="search" placeholder="search...">
        <input type="submit" value="Search">
    </form>

            </div>
        </div>
    </div>
</nav>

<!-- Inventory Management -->
<div class="container">
    <center>
        <br>
        <br>
        <h3>Pull out Items</h3>
    </center>
    <a href="main.php" class="refresh-btn">Refresh</a>
    <br><br>

    <!-- Add Inventory Form -->
    <form action="add_inventory.php" method="POST">
        <label for="id_number">User Name:</label>
        <input type="text" id="id_number" name="id_number" required><br><br>

        <label for="name">Name of Item:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" required><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br><br>

        <input type="submit" value="SUBMIT">
    </form>

    <!-- List Inventory -->
    <h3>List</h3>
    
    <?php
    include('db.php');

    // Check if a search term was submitted
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Modify the SQL query to filter based on the search term
    $sql = "SELECT * FROM inventory WHERE id_number LIKE '%$searchTerm%' OR name LIKE '%$searchTerm%'";

    $result = $conn->query($sql);

    echo "<table>
            <tr>
                <th>User ID</th>
                <th>ID Number</th>
                <th>Name of Item</th>
                <th>Quantity</th>
                <th>Branch</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>";

    if ($result->num_rows > 0) {
        // Display the results
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['id_number'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>" . $row['branch'] . "</td>
                    <td>" . $row['address'] . "</td>
                    <td>" . $row['created_at'] . "</td>
                    <td>
                        <form action='update_inventory.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='text' name='id_number' value='" . $row['id_number'] . "' required>
                            <input type='text' name='name' value='" . $row['name'] . "' required>
                            <input type='number' name='quantity' value='" . $row['quantity'] . "' required>
                            <input type='text' name='branch' value='" . $row['branch'] . "' required>
                            <input type='text' name='address' value='" . $row['address'] . "' required>
                            <input type='submit' value='Update'>
                        </form>
                        <form action='delete_inventory.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <input type='submit' value='Delete' onclick='return confirm(\"Are you sure?\");'>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

    $conn->close();
    ?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
