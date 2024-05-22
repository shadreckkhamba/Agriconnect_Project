<?php

ob_start(); // Start output buffering to prevent headers already sent error
session_start(); // Start the session
include 'inc/config.php'; // Include the configuration file
unset($_SESSION['user']); // Unset the 'user' session variable
header("location: login.php"); // Redirect to the login page

?>
