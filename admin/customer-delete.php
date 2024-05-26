<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}

	foreach($statement as $row){
		$cust_email= $row['cust_email'];
		$statement1 = $pdo->prepare("DELETE FROM tbl_user WHERE email=?");
		$statement1->execute(array($cust_email));
	}

}
?>

<?php

	// Delete from tbl_customer
	$statement = $pdo->prepare("DELETE FROM tbl_customer WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_rating
	$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE cust_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: customer.php');
?>