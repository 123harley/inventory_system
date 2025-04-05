<?php
session_start();
include('Inventory.php');  // Include your Inventory class

$loginError = '';
$registerError = '';
$adminExistsError = '';  // To check if admin already exists

// Check if an admin account already exists in the system
$inventory = new Inventory();
$checkAdminExist = $inventory->checkEmailExists("admin@example.com");  // Default admin email

// Login Functionality
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = $inventory->login($email, $password);
    if (!empty($login)) {
        // Successful login
        $_SESSION['admin_id'] = $login[0]['id'];
        $_SESSION['admin_email'] = $login[0]['email'];
        $_SESSION['admin_role'] = $login[0]['role'];
        header("Location: admin_dashboard.php");  // Redirect to the admin dashboard
    } else {
        $loginError = "Invalid email or password!";
    }
}

// Register Functionality (only if no admin account exists)
if (isset($_POST['register_email']) && isset($_POST['register_password'])) {
    if ($checkAdminExist) {
        $adminExistsError = "An admin account already exists!";
    } else {
        $registerEmail = $_POST['register_email'];
        $registerPassword = $_POST['register_password'];

        // Register the new admin account
        if ($inventory->registerAdmin($registerEmail, $registerPassword)) {
            $login = $inventory->login($registerEmail, $registerPassword);
            $_SESSION['admin_id'] = $login[0]['id'];
            $_SESSION['admin_email'] = $login[0]['email'];
            $_SESSION['admin_role'] = $login[0]['role'];
            header("Location: admin_dashboard.php");  // Redirect to the admin dashboard
        } else {
            $registerError = "Error during registration, please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            background: linear-gradient(to right, rgb(44, 67, 97), rgb(9, 13, 238));  /* Vibrant gradient background */
            font-family: 'Roboto', sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: white;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        /* Keyframes for custom animation */
        @keyframes in-circle-swoop {
            from {
                clip-path: var(--circle-top-right-out);
            }
            to {
                clip-path: var(--circle-bottom-right-in);
            }
        }

        /* Add custom transition style */
        [transition-style="in:custom:circle-swoop"] {
            --transition__duration: 5s;
            animation-name: in-circle-swoop;
        }

        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px;
            margin: 50px auto;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: 0.5s ease-in-out; /* Custom transition */
            animation: in-circle-swoop var(--transition__duration) ease-in-out; /* Apply animation */
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 2px solid #ff6a00;
            border-radius: 8px;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #ee0979;
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #ff6a00;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #ee0979;
        }

        .alert {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .toggle-btn {
            cursor: pointer;
            background: none;
            border: none;
            font-size: 18px;
            position: absolute;
            right: 10px;
            top: 15px;
        }

        .forgot-password {
            color: #ff6a00;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }

        .forgot-password:hover {
            color: #ee0979;
        }

        .register-link {
            color: #ff6a00;
            font-size: 16px;
            text-decoration: none;
        }

        .register-link:hover {
            color: #ee0979;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container" transition-style="in:custom:circle-swoop">
    <img src="n.png" alt="Logo" />
    <h1>Admin Login</h1>

    <!-- Login Form -->
    <form method="post">
        <?php if ($loginError) { ?>
            <div class="alert"><?php echo $loginError; ?></div>
        <?php } ?>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group" style="position: relative;">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="button" class="toggle-btn" id="toggle-password" onclick="togglePassword()">👁️</button>
        </div>

        <script>
            // Function to toggle the password visibility
            function togglePassword() {
                var passwordField = document.getElementById("password");
                var toggleButton = document.getElementById("toggle-password");

                if (passwordField.type === "password") {
                    passwordField.type = "text"; // Show the password
                    toggleButton.textContent = "🙈"; // Change button icon
                } else {
                    passwordField.type = "password"; // Hide the password
                    toggleButton.textContent = "👁️"; // Change button icon back
                }
            }
        </script>

        <a href="forgot_password_request.php" class="forgot-password">Forgot Password?</a>
        <br>
        <button type="submit" class="btn">Login</button>
    </form>

    <br>
    <a href="#" class="register-link">Register as Admin</a>
    <br>
    <a href="login.php" class="forgot-password">Login as user only</a>
       
</div>

</body>
</html>
