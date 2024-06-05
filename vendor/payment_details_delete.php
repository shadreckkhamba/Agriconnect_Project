<?php require_once('header.php'); // Include the header file ?>

<?php
if(!isset($_REQUEST['id'])) { // Check if the 'id' parameter is not set in the request
	header('location: logout.php'); // Redirect to logout if 'id' is not set
	exit; // Exit the script
} else {
	// Check if the provided 'id' is valid
	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?"); // Prepare SQL query to check user by 'id'
	$statement->execute(array($_REQUEST['id'])); // Execute the query with the provided 'id'
	$total = $statement->rowCount(); // Get the number of rows returned
	if( $total == 0 ) { // If no rows are returned, the 'id' is not valid
		header('location: logout.php'); // Redirect to logout
		exit; // Exit the script
	}
}
?>

<?php
// Update the payment details to "None" for the user with the provided 'id'
$statement = $pdo->prepare("UPDATE tbl_user SET payment_type=?, payment_details=? WHERE id=?"); // Prepare SQL query to update payment details
$statement->execute(array("None", "None", $_REQUEST['id'])); // Execute the query with the provided values

$success_message = 'Payment Method is Deleted successfully!'; // Set success message

header('location: payment_details.php'); // Redirect to the payment details page
?>