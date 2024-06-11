<?php require_once('header.php'); ?>

<?php
// Check if the required 'id' and 'id1' parameters are set in the request
if( !isset($_REQUEST['id']) || !isset($_REQUEST['id1']) ) {
	// Redirect to logout if either parameter is missing
	header('location: logout.php');
	exit;
} else {
	// Prepare a statement to check if the provided 'id' exists in the 'tbl_product_photo' table
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE pp_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	// If no record is found with the provided 'id', redirect to logout
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
// Fetch the photo details for the given 'id'
$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE pp_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$photo = $row['photo'];
}

// If a photo exists, unlink (delete) it from the server
if($photo!='') {
	unlink('../assets/uploads/product_photos/'.$photo);	
}

// Prepare a statement to delete the record from 'tbl_product_photo' table
$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE pp_id=?");
$statement->execute(array($_REQUEST['id']));

// Redirect to the product edit page with the 'id1' parameter
header('location: product-edit.php?id='.$_REQUEST['id1']);
?>
