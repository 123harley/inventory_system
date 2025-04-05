<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Send a password reset link (this is a simplified version, normally you'd send a unique token)
        echo "Password reset link has been sent to your email.";
        // In a real-world scenario, you'd send an actual email here.
    } else {
        echo "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <form method="post" action="reset_password.php">
        <input type="email" name="email" placeholder="Email" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
