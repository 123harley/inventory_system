<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $id_number = $_POST['id_number'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $branch = $_POST['branch'];
    $address = $_POST['address'];

    $sql = "UPDATE inventory SET id_number='$id_number', name='$name', quantity=$quantity, branch='$branch', address='$address' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message'>Record updated successfully</div>";
    } else {
        echo "<div class='error-message'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #1877f2;
            text-align: center;
            margin-top: 50px;
        }

        form {
            width: 40%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1877f2;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #155cb1;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            font-size: 16px;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-top: 20px;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            font-size: 16px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-btn {
            display: block;
            width: 120px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<a href="main.php" class="back-btn">Back</a>

</body>
</html>
