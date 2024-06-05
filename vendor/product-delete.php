<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}
?>

<?php
    // Getting photo ID to unlink from folder
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
        $p_featured_photo = $row['p_featured_photo'];
        unlink('../assets/uploads/'.$p_featured_photo);
    }

    // Getting other photo ID to unlink from folder
    $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
        $photo = $row['photo'];
        unlink('../assets/uploads/product_photos/'.$photo);
    }

    // Delete from the table of Products
    $statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));

    // Delete from the table of produc photos
    $statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));

    // Delete from product size tb
    $statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));

    // Delete from tbl_product_color
    $statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));

    // Delete from tbl_rating
    $statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));

    // Delete from payment table
    $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
        $statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
        $statement1->execute(array($row['payment_id']));
    }

    // Delete from order table
    $statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
    $statement->execute(array($_REQUEST['id']));

    header('location: product.php');
?>
