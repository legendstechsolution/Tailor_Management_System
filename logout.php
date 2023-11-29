<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired page after logout
header("Location: login.php"); // Replace 'login.php' with the appropriate page
exit;
?>
