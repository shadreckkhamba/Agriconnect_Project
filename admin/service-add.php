<?php require_once('header.php'); ?>

<?php
// Check if form is submitted
if(isset($_POST['form1'])) {
	$valid = 1;

	// Validate title
	if(empty($_POST['title'])) {
		$valid = 0;
		$error_message .= 'Title can not be empty<br>';
	}

	// Validate content
	if(empty($_POST['content'])) {
		$valid = 0;
		$error_message .= 'Content can not be empty<br>';
	}

	// Handle file upload
	$path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);

        // Check for valid file extensions
        if($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }

	// If validation passes
	if($valid == 1) {

		// Get auto increment id for the new record
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_service'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id = $row[10];
		}

		// Define the final file name
		$final_name = 'service-' . $ai_id . '.' . $ext;

		// Move the uploaded file to the target directory
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);

		// Insert data into the database
		$statement = $pdo->prepare("INSERT INTO tbl_service (title, content, photo) VALUES (?, ?, ?)");
		$statement->execute(array($_POST['title'], $_POST['content'], $final_name));
			
		$success_message = 'Service is added successfully!';

		// Clear the form values after submission
		unset($_POST['title']);
		unset($_POST['content']);
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Service</h1>
	</div>
	<div class="content-header-right">
		<a href="service.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">

			<!-- Display error message if any -->
			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<p>
					<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>

			<!-- Display success message if any -->
			<?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<!-- Service form -->
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<!-- Title input field -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Title <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
							</div>
						</div>
						<!-- Content textarea field -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-6">
								<textarea class="form-control" name="content" style="height:200px;"><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
							</div>
						</div>
						<!-- Photo file input field -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
							</div>
						</div>
						<!-- Submit button -->
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
