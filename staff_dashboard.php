<?php
session_start();

// Check if user is staff
if ($_SESSION['user_role'] != 'staff') {
    header("Location: login.php"); // Redirect if not staff
    exit();
}

// Staff dashboard content
echo "<h1>Staff Dashboard</h1>";
?>
