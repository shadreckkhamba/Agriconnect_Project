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
