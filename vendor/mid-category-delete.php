Certainly! Here is your PHP code with added comments for better understanding:

```php
<?php require_once('header.php'); ?>

<?php
// Preventing direct access to this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php'); // Redirect to logout if id is not set
	exit;
} else {
	// Check if the provided id is valid
	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php'); // Redirect to logout if id is invalid
		exit;
	}
}
?>

<?php
// Fetching all end category ids related to the mid category
$statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
$statement->execute(array($_REQUEST['id']));
$total = $statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ecat_ids[] = $row['ecat_id']; // Store end category ids in an array
}

if(isset($ecat_ids)) {

	// Loop through each end category id to fetch associated products
	for($i=0;$i<count($ecat_ids);$i++) {
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=?");
		$statement->execute(array($ecat_ids[$i]));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$p_ids[] = $row['p_id']; // Store product ids in an array
		}
	}

	// Loop through each product id to delete associated data
	for($i=0;$i<count($p_ids);$i++) {

		// Fetch featured photo to unlink from folder
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$p_featured_photo = $row['p_featured_photo'];
			unlink('../assets/uploads/'.$p_featured_photo); // Unlink featured photo
		}

		// Fetch other photos to unlink from folder
		$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$photo = $row['photo'];
			unlink('../assets/uploads/product_photos/'.$photo); // Unlink other photos
		}

		// Delete from tbl_product
		$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));

		// Delete from tbl_product_photo
		$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));

		// Delete from tbl_product_size
		$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));

		// Delete from tbl_product_color
		$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));

		// Delete from tbl_rating
		$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
		$statement->execute(array($p_ids[$i]));

		// Delete from tbl_payment for associated orders
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
		$statement->execute(array($p_ids[$i]));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
			$statement1->execute(array($row['payment_id']));
		}

		// Delete from tbl_order
		$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
		$statement->execute(array($p_ids[$i]));
	}

	// Delete from tbl_end_category
	for($i=0;$i<count($ecat_ids);$i++) {
		$statement = $pdo->prepare("DELETE FROM tbl_end_category WHERE ecat_id=?");
		$statement->execute(array($ecat_ids[$i]));
	}
}

// Delete from tbl_mid_category
$statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE mcat_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: mid-category.php'); // Redirect to mid-category page
?>