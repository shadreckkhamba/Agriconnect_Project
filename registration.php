<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['acc_type'])) {
        $valid = 0;
        $error_message .= "Please Specify either customer or vendor"."<br>";
    }


    if( empty($_POST['cust_password']) || empty($_POST['cust_re_password']) ) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if( !empty($_POST['cust_password']) && !empty($_POST['cust_re_password']) ) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }

    if($valid == 1) {

        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_email,
                                        cust_phone,
                                        cust_address,
                                        cust_city,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status,
                                        acc_type
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

                                $statement1=$statement->execute(array(
                                    strip_tags($_POST['cust_name']),
                                    strip_tags($_POST['cust_email']),
                                    strip_tags($_POST['cust_phone']),
                                    strip_tags($_POST['cust_address']),
                                    strip_tags($_POST['cust_city']),
                                    md5($_POST['cust_password']),
                                    $token,
                                    $cust_datetime,
                                    $cust_timestamp,
                                    1,
                                    $_POST['acc_type']
                                ));

                                $statement2 = $pdo->prepare("INSERT INTO tbl_user(full_name,email,phone,password,photo,role,status) VALUES(?,?,?,?,?,?,?)");

                                $statement2=$statement2->execute(array(strip_tags($_POST['cust_name']),strip_tags($_POST['cust_email']),strip_tags($_POST['cust_phone']),md5($_POST['cust_password']),'user-1.png',$_POST['acc_type'],'Active'));


        unset($_POST['cust_name']);
        unset($_POST['acc_type']);
        unset($_POST['cust_email']);
        unset($_POST['cust_phone']);
        unset($_POST['cust_address']);


        header("location: login.php");
    
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_16; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> *</label>
                                    <input type="text" class="form-control" name="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> *</label>
                                    <input type="text" class="form-control" name="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?> *</label>
                                    <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">Register as *</label>
                                    <select name="acc_type" class="form-control select2">
                                        <option value="customer">Customer</option>
                                        <option value="vendor">Vendor</option>
                                    </select>                                    
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo "District"; ?> *</label>
                                    <input type="text" class="form-control" name="cust_city" value="<?php if(isset($_POST['cust_city'])){echo $_POST['cust_city'];} ?>">
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_98; ?> *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-danger" value="<?php echo LANG_VALUE_15; ?>" name="form1">
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>