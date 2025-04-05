<?php
session_start();

// Check if user is manager
if ($_SESSION['user_role'] != 'manager') {
    header("Location: login.php"); // Redirect if not manager
    exit();
}

// Manager dashboard content
echo "<h1>Manager Dashboard</h1>";
?>
