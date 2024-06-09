<?php
include 'inc/config.php'; // Include the configuration file for database connection

if($_POST['id']) { // Check if 'id' is set in the POST request
	$id = $_POST['id']; // Get the 'id' from the POST request
	
	// Prepare SQL query to select mid categories based on the top category ID
	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
	$statement->execute(array($id)); // Execute the query with the provided 'id'
	$result = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as an associative array

	// Output the default option
	?><option value="">Select Mid Level Category</option><?php						
	foreach ($result as $row) { // Loop through the results
		?>
        <option value="<?php echo $row['mcat_id']; ?>"><?php echo $row['mcat_name']; ?></option> <!-- Output each mid category as an option -->
        <?php
	}
}
?>
