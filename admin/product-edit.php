<?php require_once('header.php'); ?>

<?php
// Check if form is submitted
if(isset($_POST['form1'])) {
	$valid = 1;
    $error_message = '';

    // Validate form inputs
    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top level category<br>";
    }

    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a mid level category<br>";
    }

    if(empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select an end level category<br>";
    }

    if(empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty<br>";
    }

    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price cannot be empty<br>";
    }

    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity cannot be empty<br>";
    }

    // Handle featured photo upload
    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        // Handle additional photos upload
        if(isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {
            $photo = array_values(array_filter($_FILES['photo']["name"]));
            $photo_temp = array_values(array_filter($_FILES['photo']["tmp_name"]));

            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1 = $row[10];
            }
            $z = $next_id1;

            $m = 0;
            for($i = 0; $i < count($photo); $i++) {
                $my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
                if($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
                    $final_name1[$m] = $z . '.' . $my_ext1;
                    move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $final_name1[$m]);
                    $m++;
                    $z++;
                }
            }

            if(isset($final_name1)) {
                for($i = 0; $i < count($final_name1); $i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo, p_id) VALUES (?, ?)");
                    $statement->execute(array($final_name1[$i], $_REQUEST['id']));
                }
            }
        }

        // Update product information in the database
        if($path == '') {
            // Update without changing featured photo
            $statement = $pdo->prepare("UPDATE tbl_product SET 
                p_name = ?, 
                p_old_price = ?, 
                p_current_price = ?, 
                p_qty = ?, 
                p_description = ?, 
                p_short_description = ?, 
                p_feature = ?, 
                p_condition = ?, 
                p_return_policy = ?, 
                p_is_featured = ?, 
                p_is_active = ?, 
                ecat_id = ? 
                WHERE p_id = ?");
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
            // Update and change featured photo
            unlink('../assets/uploads/' . $_POST['current_photo']);

            $final_name = 'product-featured-' . $_REQUEST['id'] . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);

            $statement = $pdo->prepare("UPDATE tbl_product SET 
                p_name = ?, 
                p_old_price = ?, 
                p_current_price = ?, 
                p_qty = ?, 
                p_featured_photo = ?, 
                p_description = ?, 
                p_short_description = ?, 
                p_feature = ?, 
                p_condition = ?, 
                p_return_policy = ?, 
                p_is_featured = ?, 
                p_is_active = ?, 
                ecat_id = ? 
                WHERE p_id = ?");
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

        // Update product sizes
        if(isset($_POST['size'])) {
            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id = ?");
            $statement->execute(array($_REQUEST['id']));

            foreach($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id, p_id) VALUES (?, ?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id = ?");
            $statement->execute(array($_REQUEST['id']));
        }

        // Update product colors
        if(isset($_POST['color'])) {
            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id = ?");
            $statement->execute(array($_REQUEST['id']));

            foreach($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id, p_id) VALUES (?, ?)");
                $statement->execute(array($value, $_REQUEST['id']));
            }
        } else {
            $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id = ?");
            $statement->execute(array($_REQUEST['id']));
        }

        $success_message = 'Product is updated successfully.';
    }
}
?>

<?php
// Ensure valid product ID is provided
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id = ?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if($total == 0) {
		header('location: logout.php');
		exit;
	}
}

// Fetch existing product details
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id = ?");
$statement->execute(array($_REQUEST['id']));
$product = $statement->fetch(PDO::FETCH_ASSOC);

$p_name = $product['p_name'];
$p_old_price = $product['p_old_price'];
$p_current_price = $product['p_current_price'];
$p_qty = $product['p_qty'];
$p_featured_photo = $product['p_featured_photo'];
$p_description = $product['p_description'];
$p_short_description = $product['p_short_description'];
$p_feature = $product['p_feature'];
$p_condition = $product['p_condition'];
$p_return_policy = $product['p_return_policy'];
$p_is_featured = $product['p_is_featured'];
$p_is_active = $product['p_is_active'];
$ecat_id = $product['ecat_id'];

// Fetch category details
$statement = $pdo->prepare("SELECT * 
                            FROM tbl_end_category t1
                            JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id
                            JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id
                            WHERE t1.ecat_id = ?");
$statement->execute(array($ecat_id));
$category = $statement->fetch(PDO::FETCH_ASSOC);

$ecat_name = $category['ecat_name'];
$mcat_id = $category['mcat_id'];
$tcat_id = $category['tcat_id'];

// Fetch product sizes
$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id = ?");
$statement->execute(array($_REQUEST['id']));
$sizes = $statement->fetchAll(PDO::FETCH_ASSOC);
$size_id = array_column($sizes, 'size_id');

// Fetch product colors
$statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id = ?");
$statement->execute(array($_REQUEST['id']));
$colors = $statement->fetchAll(PDO::FETCH_ASSOC);
$color_id = array_column($colors, 'color_id');
?>

<!-- Display validation errors -->
<?php if($error_message): ?>
<div class="callout callout-danger">
    <p>
    <?php echo $error_message; ?>
    </p>
</div>
<?php endif; ?>

<!-- Display success message -->
<?php if($success_message): ?>
<div class="callout callout-success">
    <p><?php echo $success_message; ?></p>
</div>
<?php endif; ?>

<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
    <input type="hidden" name="ecat_id" value="<?php echo $ecat_id; ?>">
    <input type="hidden" name="tcat_id" value="<?php echo $tcat_id; ?>">
    <input type="hidden" name="mcat_id" value="<?php echo $mcat_id; ?>">
    
    <!-- Product Details -->
    <div class="form-group">
        <label for="p_name" class="col-sm-2 control-label">Product Name *</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="p_name" value="<?php echo $p_name; ?>">
        </div>
    </div>
    
    <!-- More product fields (similar to above) -->
    
    <!-- Submit button -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success" name="form1">Update</button>
        </div>
    </div>
</form>

<?php require_once('footer.php'); ?>
