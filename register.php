<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");

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
    } 

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124."<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127."<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128."<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129."<br>";
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


        $cust_name=$_POST['cust_name'];
        $cust_cname=$_POST['cust_cname'];
        $cust_email=$_POST['cust_email'];
        $cust_phone=$_POST['cust_phone'];
        $cust_country=$_POST['cust_country'];
        $cust_address=$_POST['cust_address'];
        $cust_city=$_POST['cust_city'];
        $cust_state=$_POST['cust_state'];
        $cust_zip=$_POST['cust_zip'];
        $md5=md5($_POST['cust_password']);


        // saving into the database
        $sql = "INSERT INTO `ecommerceweb`.`tbl_customer` (cust_name,cust_cname,cust_email,cust_phone,cust_country,cust_address,cust_city,cust_state,cust_zip,cust_b_name,cust_b_cname,cust_b_phone,cust_b_country,cust_b_address,cust_b_city) VALUES ('$cust_name','$cust_cname','$cust_email','$cust_phone','$cust_country','$cust_address','$cust_city','$cust_state','$cust_zip','','','','','','')";

        
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Data inserted successfully.";
        } else {
            echo "Error: Unable to insert data. Please try again later. Error Message: " . mysqli_error($conn);
        }

        die;

    }
}
?>