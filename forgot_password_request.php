<?php
session_start();
include('Inventory.php');  // Include your Inventory class

$inventory = new Inventory();
$emailError = '';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists
    if ($inventory->checkEmailExists($email)) {
        // Generate a unique token for the reset link
        $token = bin2hex(random_bytes(50));  // 50 bytes token
        $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;

        // Save the token with the email in your database (assuming you have a 'password_resets' table)
        if ($inventory->storePasswordResetToken($email, $token)) {
            // Send the email with the reset link (Make sure to configure email settings)
            mail($email, "Password Reset Request", "Click the following link to reset your password: " . $resetLink);
            echo "A password reset link has been sent to your email.";
        } else {
            $emailError = "Failed to generate reset link. Please try again.";
        }
    } else {
        $emailError = "This email address does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="post">
        <?php if ($emailError) { ?>
            <div class="alert"><?php echo $emailError; ?></div>
        <?php } ?>
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
