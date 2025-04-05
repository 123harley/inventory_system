<?php
// Start the session
session_start();

// Destroy all session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: index.php");
exit; // Ensure no further code is executed
?>


<div class="logout-section">
<a href="logout.php" class="logout-btn">Logout</a>