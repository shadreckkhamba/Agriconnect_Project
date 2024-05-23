```php
<?php require_once('header.php'); ?>

<?php
// Check if user has submitted the form
if(isset($_POST['form1'])) {
    $valid = 1; // Flag for form validation

    // Validate form inputs from users
    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a top level category.<br>";
    }

    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a mid level category.<br>";
    }

    if(empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must select an end level category.<br>";
    }

    if(empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty.<br>";
    }

    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price cannot be empty.<br>";
    }

    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity cannot be empty.<br>";
    }

    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    // Validate uploaded file
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file.<br>';
        }
    }
    
    // Proceed if all validations passed
    if($valid == 1) {
        // Handle additional photos upload
        if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) ) {
            // Process additional photos
            $photo = $_FILES['photo']["name"];
            $photo_temp = $_FILES['photo']["tmp_name"];

            // Iterate through additional photos
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1=$row[10];
            }
            $z = $next_id1;

            $m=0;
            for($i=0;$i<count($photo);$i++) {
                $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
                if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
                    $final_name1[$m] = $z.'.'.$my_ext1;
                    move_uploaded_file($photo_temp[$i],"../assets/uploads/product_photos/".$final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if(isset($final_name1)) {
                // Insert additional photos into database
                for($i=0;$i<count($final_name1);$i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i],$_REQUEST['id']));
                }
            }
        }
    }
}

// Check if the form is submitted
if(isset($_POST['form1'])) {
    $valid = 1; // Flag for form validation

    // Validate form inputs
    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a top level category.<br>";
    }

    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must select a mid level category.<br>";
    }

    if(empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must select an end level category.<br>";
    }

    if(empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty.<br>";
    }

    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price cannot be empty.<br>";
    }

    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity cannot be empty.<br>";
    }

    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    // Validate uploaded file
    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must upload a jpg, jpeg, gif, or png file.<br>';
        }
    }
	
    // Proceed if all validations passed
    if($valid == 1) {
        // Handle additional photos upload
        if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) ) {
            // Process additional photos
            $photo = $_FILES['photo']["name"];
            $photo_temp = $_FILES['photo']["tmp_name"];

            // Iterate through additional photos
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1=$row[10];
            }
            $z = $next_id1;

            $m=0;
            for($i=0;$i<count($photo);$i++) {
                $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
                if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
                    $final_name1[$m] = $z.'.'.$my_ext1;
                    move_uploaded_file($photo_temp[$i],"../assets/uploads/product_photos/".$final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if(isset($final_name1)) {
                // Insert additional photos into database
                for($i=0;$i<count($final_name1);$i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
                    $statement->execute(array($final_name1[$i],$_REQUEST['id']));
                }
            }            
        }

        // Check if the main photo needs to be updated or not
        if($path == '') {
            // Update product without changing main photo
            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    p_condition=?,
                                    p_return_policy=?,
                                    p_is_featured=?,
                                    p_is_active=?,
                                    ecat_id=?

                                    WHERE p_id=?");
            $statement->execute(array(
                                    $_POST['p_name'],
                                    $_POST['p_old_price'],
                                    $_POST['p_current_price'],
                                    $_POST['p_qty'],
                                    $_POST['p_description'],
                                    $_POST['p_short_description'],
                                    $_POST['p_feature'],
                                    $_POST['p_condition'],
                                    $_POST['p_return_policy'],
                                    $_POST['p_is_featured'],
                                    $_POST['p_is_active'],
                                    $_POST['ecat_id'],
                                    $_REQUEST['id']
                                ));
        } else {
            // Update product with changing main photo
            unlink('../assets/uploads/'.$_POST['current_photo']);

            $final_name = 'product-featured-'.$_REQUEST['id'].'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            $statement = $pdo->prepare("UPDATE tbl_product SET 
                                    p_name=?, 
                                    p_old_price=?, 
                                    p_current_price=?, 
                                    p_qty=?,
                                    p_featured_photo=?,
                                    p_description=?,
                                    p_short_description=?,
                                    p_feature=?,
                                    p_condition=?,
                                    p_return_policy=?,
                                    p_is_featured=?,
                                    p_is_active=?,
                                    ecat_id=?

                                    WHERE p_id=?");
            $statement->execute(array(
                                    $_POST['p_name'],
                                    $_POST['p_old_price'],
                                    $_POST['p_current_price'],
                                    $_POST['p_qty'],
                                    $final_name,
                                    $_POST['p_description'],
                                    $_POST['p_short_description'],
                                    $_POST['p_feature'],
                                    $_POST['p_condition'],
                                    $_POST['p_return_policy'],
                                    $_POST['p_is_featured'],
                                    $_POST['p_is_active'],
                                    $_POST['ecat_id'],
                                    $_REQUEST['id']
                                ));
        }

        // Handle product sizes
        if(isset($_POST['size'])) {
            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));
        }

        // Handle product colors
        if(isset($_POST['color'])) {
            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));

            foreach($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
            $statement->execute(array($_REQUEST['id']));
        }
    
        $success_message = 'Product is updated successfully.';
    }
}
?>

```php
<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<!-- Display error message if there is any -->
			<div class="callout callout-danger">
				<p>
					<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<!-- Display success message if there is any -->
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Top Level Category Name <span>*</span></label>
							<div class="col-sm-4">
								<!-- Dropdown for selecting top level category -->
								<select name="tcat_id" class="form-control select2 top-cat">
		                            <option value="">Select Top Level Category</option>
		                            <?php
		                            // Fetch top level categories from the database
		                            $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
		                            $statement->execute();
		                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
		                            foreach ($result as $row) {
		                                ?>
		                                <!-- Display each top level category -->
		                                <option value="<?php echo $row['tcat_id']; ?>" <?php if($row['tcat_id'] == $tcat_id){echo 'selected';} ?>><?php echo $row['tcat_name']; ?></option>
		                                <?php
		                            }
		                            ?>
		                        </select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Mid Level Category Name <span>*</span></label>
							<div class="col-sm-4">
								<!-- Dropdown for selecting mid level category -->
								<select name="mcat_id" class="form-control select2 mid-cat">
		                            <option value="">Select Mid Level Category</option>
		                            <?php
		                            // Fetch mid level categories based on selected top level category
		                            $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ? ORDER BY mcat_name ASC");
		                            $statement->execute(array($tcat_id));
		                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
		                            foreach ($result as $row) {
		                                ?>
		                                <!-- Display each mid level category -->
		                                <option value="<?php echo $row['mcat_id']; ?>" <?php if($row['mcat_id'] == $mcat_id){echo 'selected';} ?>><?php echo $row['mcat_name']; ?></option>
		                                <?php
		                            }
		                            ?>
		                        </select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">End Level Category Name <span>*</span></label>
							<div class="col-sm-4">
								<!-- Dropdown for selecting end level category -->
								<select name="ecat_id" class="form-control select2 end-cat">
		                            <option value="">Select End Level Category</option>
		                            <?php
		                            // Fetch end level categories based on selected mid level category
		                            $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id = ? ORDER BY ecat_name ASC");
		                            $statement->execute(array($mcat_id));
		                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
		                            foreach ($result as $row) {
		                                ?>
		                                <!-- Display each end level category -->
		                                <option value="<?php echo $row['ecat_id']; ?>" <?php if($row['ecat_id'] == $ecat_id){echo 'selected';} ?>><?php echo $row['ecat_name']; ?></option>
		                                <?php
		                            }
		                            ?>
		                        </select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
							<div class="col-sm-4">
								<!-- Input field for product name -->
								<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Old Price<br><span style="font-size:10px;font-weight:normal;">(In MWK)</span></label>
							<div class="col-sm-4">
								<!-- Input field for old price -->
								<input type="text" name="p_old_price" class="form-control" value="<?php echo $p_old_price; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In MWK)</span></label>
							<div class="col-sm-4">
								<!-- Input field for current price -->
								<input type="text" name="p_current_price" class="form-control" value="<?php echo $p_current_price; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
							<div class="col-sm-4">
								<!-- Input field for quantity -->
								<input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
							</div>
						</div>
						
						
						<div class="form

-group">
							<label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<!-- Display existing featured photo -->
								<img src="../assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
								<input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Change Featured Photo </label>
							<div class="col-sm-4" style="padding-top:4px;">
								<!-- Input field for changing featured photo -->
								<input type="file" name="p_featured_photo">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Other Photos</label>
							<div class="col-sm-4" style="padding-top:4px;">
								<!-- Display other photos -->
								<table id="ProductTable" style="width:100%;">
			                        <tbody>
			                        	<?php
			                        	// Fetch other photos of the product
			                        	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
			                        	$statement->execute(array($_REQUEST['id']));
			                        	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			                        	foreach ($result as $row) {
			                        		?>
											<tr>
				                                <td>
				                                    <img src="../assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin-bottom:5px;">
				                                </td>
				                                <td style="width:28px;">
				                                	<!-- Button to delete other photos -->
				                                	<a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
				                                </td>
				                            </tr>
			                        		<?php
			                        	}
			                        	?>
			                        </tbody>
			                    </table>
							</div>
							<div class="col-sm-2">
			                    <!-- Button to add new item -->
			                    <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
			                </div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<!-- Textarea for product description -->
								<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Short Description</label>
							<div class="col-sm-8">
								<!-- Textarea for short product description -->
								<textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_short_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Features</label>
							<div class="col-sm-8">
								<!-- Textarea for product features -->
								<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Conditions</label>
							<div class="col-sm-8">
								<!-- Textarea for product conditions -->
								<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"><?php echo $p_condition; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Return Policy</label>
							<div class="col-sm-8">
								<!-- Textarea for product return policy -->
								<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"><?php echo $p_return_policy; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Featured?</label>
							<div class="col-sm-8">
								<!-- Dropdown for selecting whether the product is featured -->
								<select name="p_is_featured" class="form-control" style="width:auto;">
									<option value="0" <?php if($p_is_featured == '0'){echo 'selected';} ?>>No</option>
									<option value="1" <?php if($p_is_featured == '1'){echo 'selected';} ?>>Yes</option>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-8">
								<!-- Dropdown for selecting whether the product is active -->
								<select name="p_is_active" class="form-control" style="width:auto;">
									<option value="0" <?php if($p_is_active == '0'){echo 'selected';} ?>>No</option>
									<option value="1" <?php if($p_is_active == '1'){echo 'selected';} ?>>Yes</option>
								</select> 
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<!-- Button to update product details -->
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>
<?php
				// Prepare and execute SQL statement to fetch product photos
				$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
				$statement->execute(array($_REQUEST['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result as $row) {
				?>
					<tr>
						<td>
							<!-- Display product photo -->
							<img src="../assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width:150px;margin-bottom:5px;">
						</td>
						<td style="width:28px;">
							<!-- Button to delete product photo -->
							<a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">X</a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>
				</table>
				</div>
				<div class="col-sm-2">
					<!-- Button to add new item -->
					<input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
				</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Description</label>
					<div class="col-sm-8">
						<!-- Textarea for product description -->
						<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Short Description</label>
					<div class="col-sm-8">
						<!-- Textarea for short product description -->
						<textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_short_description; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Features</label>
					<div class="col-sm-8">
						<!-- Textarea for product features -->
						<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Conditions</label>
					<div class="col-sm-8">
						<!-- Textarea for product conditions -->
						<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"><?php echo $p_condition; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Return Policy</label>
					<div class="col-sm-8">
						<!-- Textarea for product return policy -->
						<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"><?php echo $p_return_policy; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Is Featured?</label>
					<div class="col-sm-8">
						<!-- Dropdown for selecting whether the product is featured -->
						<select name="p_is_featured" class="form-control" style="width:auto;">
							<option value="0" <?php if($p_is_featured == '0'){echo 'selected';} ?>>No</option>
							<option value="1" <?php if($p_is_featured == '1'){echo 'selected';} ?>>Yes</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Is Active?</label>
					<div class="col-sm-8">
						<!-- Dropdown for selecting whether the product is active -->
						<select name="p_is_active" class="form-control" style="width:auto;">
							<option value="0" <?php if($p_is_active == '0'){echo 'selected';} ?>>No</option>
							<option value="1" <?php if($p_is_active == '1'){echo 'selected';} ?>>Yes</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-3 control-label"></label>
					<div class="col-sm-6">
						<!-- Button to update product details -->
						<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
					</div>
				</div>
				</div>
				</div>
				
				</form>
				
				
				</div>
				</div>
				
				</section>
				
				<?php require_once('footer.php'); ?>