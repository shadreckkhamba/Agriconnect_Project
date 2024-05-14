<?php 

ob_start();
session_start();
include 'inc/config.php'; 
unset($_SESSION['user1']);
header("location: ../login.php"); 

?>