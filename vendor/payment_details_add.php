
<?php require_once('header.php'); 
    $user_email=$_SESSION['user1']['email']; // Retrieve the user's email from the session
?>

<?php
if(isset($_POST['form1'])) { // Check if the form is submitted
	$valid = 1; // Initialize validation flag

	if(empty($_POST['payment_type'])) { // Check if payment type is empty
		$valid = 0; // Set validation flag to 0 (invalid)
		$error_message .= 'Payment method can not be empty<br>'; // Append error message
	}

	if(empty($_POST['payment_details'])) { // Check if payment details are empty
		$valid = 0; // Set validation flag to 0 (invalid)
		$error_message .= 'Payment details can not be empty<br>'; // Append error message
	}

	if($valid == 1) { 

		// Get the next auto-increment ID for tbl_service
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_service'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10]; // Store the auto-increment ID
		}
	
		// Update payment type and details for the user with the retrieved email
		$statement = $pdo->prepare("UPDATE tbl_user SET payment_type=?,payment_details=? WHERE email='$user_email'");
		$statement->execute(array($_POST['payment_type'],$_POST['payment_details']));
			
		$success_message = 'Payment Method is added successfully!'; // Set success message

		// Unset the POST variables
		unset($_POST['payment_type']);
		unset($_POST['payment_details']);
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Payment Method</h1>
	</div>
	<div class="content-header-right">
		<a href="payment_details.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<p>
					<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Payment Method <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="payment_type" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Payment Details <span>*</span></label>
							<div class="col-sm-6">
								<textarea class="form-control" name="payment_details" style="height:50px;"></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>