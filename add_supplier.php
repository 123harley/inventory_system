<?php
// Include the database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $contact_name = $_POST['contact_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Insert the data into the suppliers table
    $sql = "INSERT INTO suppliers (name, contact_name, phone, email, address)
            VALUES ('$name', '$contact_name', '$phone', '$email', '$address')";

    if ($conn->query($sql) === TRUE) {
       
    } else {
        echo "<div class='alert error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
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
            background-color:rgb(17, 126, 235);
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Main Form Container */
        .form-container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
        }

        /* Header */
        .form-container h2 {
            text-align: center;
            color: #1877f2;
            margin-bottom: 20px;
        }

        /* Form Styles */
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #1877f2;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #165eaf;
        }

        /* Success and Error Alerts */
        .alert {
            padding: 15px;
            margin-top: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .alert.success {
            background-color: #28a745;
            color: white;
        }

        .alert.error {
            background-color: #dc3545;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }

            input[type="submit"] {
                padding: 12px;
            }
        }


        /* Styling for the Back button */
.back-btn {
    background-color: #1877f2; /* Blue color */
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    text-align: center;
    cursor: pointer;
    display: inline-block;
    margin-top: 20px;
    font-size: 16px;
}

.back-btn a {
    color: white; /* White text color for the link */
    text-decoration: none; /* Remove underline */
    font-weight: bold;
}

.back-btn:hover {
    background-color: #165eaf; /* Darker blue when hovered */
}

.back-btn:focus {
    outline: none; /* Remove the outline on focus */
}

    </style>
</head>

<body>
  
    <div class="form-container">
        <h2>Add Supplier</h2>
        <form method="POST">
            <label for="name">Supplier Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="contact_name">Contact Name:</label>
            <input type="text" id="contact_name" name="contact_name">

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="address">Address:</label>
            <textarea id="address" name="address"></textarea>

            <input type="submit" value="Submit">

        </form>
        <br>
        <button class="back-btn">
    <a href="view_suppliers.php">View Suppliers</a>
</button>
        <br>
        <button class="back-btn">
    <a href="main.php">Back</a>
</button>

    </div>

</body>
</html>
