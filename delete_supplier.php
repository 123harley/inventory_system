<?php
// Include the database connection
include('db.php');

// Get the supplier ID from the URL
$supplier_id = $_GET['id'];

// Delete the supplier from the database
$sql = "DELETE FROM suppliers WHERE id = $supplier_id";

if ($conn->query($sql) === TRUE) {
    echo "Supplier deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Redirect to the view suppliers page after deletion
header("Location: view_suppliers.php");
exit();
?>
