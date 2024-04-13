<?php require_once('header.php'); ?>
<!-- fetching row banner login -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>
<!-- login form -->
<?php
if(isset($_POST['form1'])){
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])){
        $error_message = LANG_VALUE_132. '<br>';
    }
    else{
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
            $row_acc_type = $row['acc_type'];
    }
    $statement2 = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
    	$statement2->execute(array($cust_email,'Active'));
    	$total2 = $statement2->rowCount();    
        $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);  
        
        foreach($result2 as $row2) { 
            $row_password2 = $row2['password'];
}
if($total==0 && $total2==0) {
    $error_message .= LANG_VALUE_133.'<br>';
} else {
    //using MD5 form
    if( $row_password != md5($cust_password)) {
        $error_message .= LANG_VALUE_139.'<br>';
    } else {
        if($cust_status == 0) {
            $error_message .= LANG_VALUE_148.'<br>';
        } else {
            if ($row_acc_type=="customer") {
                # code...
                $_SESSION['customer'] = $row;
                header("location: ".BASE_URL."index.php");
            }else if ($row_acc_type=="vendor") {
                # code...
                $_SESSION['user'] = $row2;
                header("location: ./vendor/index.php");
                
            } else {
                $error_message .= "No user details match".'<br>';
            }
            
        }
    }
    
}
}
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_login; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_10; ?></h1>
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
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                                    <input type="email" class="form-control" name="cust_email">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-success" value="<?php echo LANG_VALUE_4; ?>" name="form1">
                                </div>
                                <a href="forget-password.php" style="color:#e4144d;"><?php echo LANG_VALUE_97; ?>?</a>
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); 
