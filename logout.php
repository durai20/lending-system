<?php
// Start the session if not already started

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page after logout
header("Location: index.php"); // Replace "login.php" with your login page's URL
exit();

?>
