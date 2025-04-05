<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $branch = $_POST['branch'];
    $address = $_POST['address'];

    $sql = "INSERT INTO inventory (id_number, name, quantity, branch, address) 
            VALUES ('$id_number', '$name', $quantity, '$branch', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "New record added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<a href="main.php">BACK</a>