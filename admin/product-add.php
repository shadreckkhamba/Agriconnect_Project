<?php require_once('header.php'); ?>  // Include header file

<?php
if(isset($_POST['form1'])) {  // Check if form is submitted
	$valid = 1;  // Validation flag

    // Check if top-level category is selected
    if(empty($_POST['tcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a top level category<br>";
    }

    // Check if mid-level category is selected
    if(empty($_POST['mcat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a mid level category<br>";
    }

    // Check if end-level category is selected
    if(empty($_POST['ecat_id'])) {
        $valid = 0;
        $error_message .= "You must have to select an end level category<br>";
    }

    // Check if product name is provided
    if(empty($_POST['p_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    // Check if current price is provided
    if(empty($_POST['p_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    // Check if quantity is provided
    if(empty($_POST['p_qty'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
    }

    // Check if featured photo is uploaded
    $path = $_FILES['p_featured_photo']['name'];
    $path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    if($path!='') {  // If photo is uploaded
        $ext = pathinfo($path, PATHINFO_EXTENSION);  // Get file extension
        $file_name = basename($path, '.' . $ext);  // Get file name without extension
        // Check if the uploaded file is a valid image format
        if($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }

    if($valid == 1) {  // If all validations pass

        $last_p_id = null; // Variable to store the last p_id value

        // Fetch the last product ID
        $statement = $pdo->prepare("SELECT p_id FROM tbl_product");
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $last_p_id = $row['p_id']; // Update $last_p_id with the current p_id value
        }

        // Increment the last p_id value by 1
        $ai_id = $last_p_id + 1;

        if(isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"])) {  // Check if additional photos are uploaded
            $photo = array();
            $photo = $_FILES['photo']["name"];
            $photo = array_values(array_filter($photo));  // Remove empty values

            $photo_temp = array();
            $photo_temp = $_FILES['photo']["tmp_name"];
            $photo_temp = array_values(array_filter($photo_temp));  // Remove empty values

            // Fetch the next ID for tbl_product_photo
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $next_id1=$row[10];
            }
            $z = $next_id1;

            $m = 0;
            for($i=0;$i<count($photo);$i++) {
                $my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);  // Get file extension
                // Check if the uploaded file is a valid image format
                if($my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif') {
                    $final_name1[$m] = $z.'.'.$my_ext1;  // Generate final file name
                    move_uploaded_file($photo_temp[$i],"../assets/uploads/product_photos/".$final_name1[$m]);  // Move uploaded file to target directory
                    $m++;
                    $z++;
                }
            }

            if(isset($final_name1)) {
                for($i=0;$i<count($final_name1);$i++) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");  // Insert photo record into database
                    $statement->execute(array($final_name1[$i],$ai_id));
                }
            }            
        }

        $final_name = 'product-featured-'.$ai_id.'.'.$ext;  // Generate final name for featured photo
        move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);  // Move uploaded featured photo to target directory

        // Saving data into the main table tbl_product
        $statement = $pdo->prepare("INSERT INTO tbl_product(
                                        p_name,
                                        p_old_price,
                                        p_current_price,
                                        p_qty,
                                        p_featured_photo,
                                        p_description,
                                        p_short_description,
                                        p_feature,
                                        p_condition,
                                        p_return_policy,
                                        p_total_view,
                                        p_is_featured,
                                        p_is_active,
                                        ecat_id
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
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
                                        0,
                                        $_POST['p_is_featured'],
                                        $_POST['p_is_active'],
                                        $_POST['ecat_id']
                                    ));

        // Insert product sizes into tbl_product_size
        if(isset($_POST['size'])) {
            foreach($_POST['size'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$ai_id));
            }
        }

        // Insert product colors into tbl_product_color
        if(isset($_POST['color'])) {
            foreach($_POST['color'] as $value) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id,p_id) VALUES (?,?)");
                $statement->execute(array($value,$ai_id));
            }
        }
    
        $success_message = 'Product is added successfully.';  // Success message
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Product</h1>  // Page header
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">View All</a>  // Link to view all products
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>  // Display error message if any
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>  // Display success message if any
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">  // Form to add product

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Top Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="tcat_id" class="form-control select2 top-cat">
                                    <option value="">Select Top Level Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");  // Fetch top level categories
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?></option>  // Display top level categories
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Mid Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="mcat_id" class="form-control select2 mid-cat">
                                    <option value="">Select Mid Level Category</option>
                                </select>  // Mid level categories will be populated dynamically
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Level Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="ecat_id" class="form-control select2 end-cat">
                                    <option value="">Select End Level Category</option>
                                </select>  // End level categories will be populated dynamically
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_name" class="form-control">  // Input for product name
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Old Price <br><span style="font-size:10px;font-weight:normal;">(In MWK)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_old_price" class="form-control">  // Input for old price
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In MWK)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_current_price" class="form-control">  // Input for current price
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Quantity <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="p_qty" class="form-control">  // Input for quantity
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Featured Photo <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="p_featured_photo">  // Input for featured photo
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photo[]" style="margin-bottom:5px;">  // Input for other photos
                                                </div>
                                            </td>
                                            <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>  // Button to delete photo
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">  // Button to add new photo input
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"></textarea>  // Input for product description
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>  // Input for short description
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Features</label>
                            <div class="col-sm-8">
                                <textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"></textarea>  // Input for product features
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Conditions</label>
                            <div class="col-sm-8">
                                <textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"></textarea>  // Input for product conditions
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Return Policy</label>
                            <div class="col-sm-8">
                                <textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"></textarea>  // Input for return policy
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="p_is_featured" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>  // Dropdown to select if product is featured
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="p_is_active" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>  // Dropdown to select if product is active
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Product</button>  // Submit button to add product
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>  // Include footer file
