<?php require_once('header.php'); ?>

<?php
//check if the customer is logged in or not
if(!isset($_SESSION['customer'])){
    exit;
}
else{
    //if customer is logged in, but admin make him inactive, then force the user to get logged out
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id = ? AND cust_status = ?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if($total){
        header('location: ' .BASE_URL.'logout.php');
        exit;
    }
}
?>

<?php
if(isset($_POST['form1'])){

    //update data into the database
    $statement = $pdo->prepare("UPDATE tbl_customer SET
                               cust_s_name = ?,
                               cust_s_phone = ?,
                               cust_s_address = ?,
                               cust_s_city = ?
                               
                               WHERE cust_id = ?");

    $statement->execute(array(
                        strip_tags($_POST['cust_s_name']),
                        strip_tags($_POST['cust_s_phone']),
                        strip_tags($_POST['cust_s_address']),
                        strip_tags($_POST['cust_s_city']),
                        $_SESSION['customer']['cust_id']
                        ));
                        
    $success_message = LANG_VALUE_122;                    

$_SESSION['customer']['cust_s_name'] = strip_tags($_POST['cust_s_name']);
$_SESSION['customer']['cust_s_phone'] = strip_tags($_POST['cust_s_phone']);
$_SESSION['customer']['cust_s_address'] = strip_tags($_POST['cust_s_address']);
$_SESSION['customer']['cust_s_city'] = strip_tags($_POST['cust_s_city']);


}
?>

<div class = "page">
    <div class = "container">
        <div class = "row">
            <div class = "clo-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class = "col-md-12">
                <div class = "user-content">
                    <?php
                    if($error_message != ''){
                        echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                    }
                    if($success_message != ''){
                        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>"; 
                    }
                    ?>
                    <form action = "" method = "post">
                        <?php $csrf->echoInputField(); ?>
                        <div class = "row">

                           <div class="col-md-6">
                            <h3><?php echo LANG_VALUE_87; ?></h3>
                            <div class = "form-group">
                                <label for = ""><?php echo LANG_VALUE_102; ?></label>
                                <input type="text" class="form-control" name="cust_s_name" value="<?php echo $_SESSION['customer']['cust_s_name']; ?>">
                        </div>

                        <div class = "form-group">
                            <label for = ""><?php echo LANG_VALUE_104; ?></label>
                            <input  type = "text" class = "form-control" name = "cust_s_phone" value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>">
                        </div>

                        <div class = "form-group">
                            <label for = ""><?php echo LANG_VALUE_105; ?></label>
                            <textarea name = "cust_s_address" class = "form-control" cols="30" rows="10" style = "height:100px;"><?php echo $_SESSION['customer']['cust_s_address']; ?></textarea>
                        </div>

                        <div class = "form-group">
                            <label for = ""><?php echo "City/District"; ?></label>
                            <input type="text" class="form-control" name="cust_s_state" value="<?php echo $_SESSION['customer']['cust_s_state']; ?>">
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_5; ?>" name="form1">
            </form>
        </div>
    </div> 
</div>
</div>
</div>

<?php require_once('footer.php'); ?>