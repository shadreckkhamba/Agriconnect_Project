<?php
ob_start();
//starting session
session_start();
//specify the path where the configuration file is
include 'admin/inc/config.php';
unset($_SESSION['customer']);
//redirect user to login page after logging out
header("location: ".BASE_URL.'login.php);
?>