<?php
// Include the database connection
include('db.php');

// Query the database to get all suppliers
$sql = "SELECT * FROM suppliers";
$result = $conn->query($sql);

echo '<button><a href="add_supplier.php">Back</a></button>'; // Back button

if ($result->num_rows > 0) {
    echo "<h2>Supplier List</h2>";
    echo "<table class='supplier-table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    // Output data for each supplier
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['contact_name'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['address'] . "</td>
                <td><a href='delete_supplier.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a></td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p>No suppliers found.</p>";
}

$conn->close();
?>

<!-- CSS for table styling -->
<style>
    /* Table Styling */
    .supplier-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(22, 18, 18, 0.1);
    }

    .supplier-table th, .supplier-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .supplier-table th {
        background-color: #1877f2;
        color: white;
        font-size: 16px;
    }

    .supplier-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .supplier-table tr:hover {
        background-color: #f1f1f1;
    }

    .supplier-table td a {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    .supplier-table td a:hover {
        text-decoration: underline;
    }

    /* Button styling for delete link */
    .delete-btn {
        background-color:rgb(7, 6, 6);
        color: black;
        padding: 6px 12px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }

    .delete-btn:hover {
        background-color:rgb(24, 22, 22);
    }

    /* Heading Styling */
    h2 {
        color: #1877f2;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Back Button Styling */
    button {
        background-color: #1877f2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-bottom: 20px;
    }

    button a {
        color: white;
        text-decoration: none;
    }

    button:hover {
        background-color: #165eaf;
    }
</style>
