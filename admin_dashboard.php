<?php
// Start the session to verify if the admin is logged in
session_start();

// Check if the user is logged in as an admin, if not, redirect to the login page
if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

include('Inventory.php');  // Include Inventory class for future management features

$adminName = $_SESSION['admin_email']; // Admin email can be used as a username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Body Styling */
        body {
            background-color:rgb(14, 55, 238);
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
            animation: fadeIn 1s ease-out;
        }

        /* Animation for fade-in effect */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Container Styling */
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            animation: slideUp 0.5s ease-out;
        }

        /* Slide-Up Animation for Container */
        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h1 {
            color: #4CAF50;
            animation: fadeIn 1.5s ease-out;
        }

        .menu {
            margin-top: 30px;
        }

        /* Styling for Menu Links */
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            animation: bounceIn 1s ease-in-out;
        }

        /* Hover effect for menu links */
        .menu a:hover {
            background-color: #45a049;
        }

        /* Button Styling */
        .logout-btn {
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            animation: bounceIn 1.5s ease-in-out;
        }

        .logout-btn:hover {
            background-color: #da190b;
        }

        /* Button Hover Animation */
        @keyframes bounceIn {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Button for 'Get Started' */
        button a {
            padding: 15px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            animation: bounceIn 1.5s ease-in-out;
        }

        button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?php echo $adminName; ?>!</h1>
    <p>You are logged in as an Admin.</p>

    <button>
        <a href="main.php">Get Started</a>
    </button>
</div>

</body>
</html>
