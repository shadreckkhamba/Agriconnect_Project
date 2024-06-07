<?php require_once('header.php'); ?>

<?php
// Check if an ID is provided in the request
if(!isset($_REQUEST['id'])) {
    // Redirect to logout if ID is not set
    header('location: logout.php');
    exit;
} else {
    // Check if the provided ID is valid
    $statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if($total == 0) {
        // Redirect to logout if no record is found with the provided ID
        header('location: logout.php');
        exit;
    }
}
?>

<?php
// Get the photo filename associated with the record to be deleted
$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $photo = $row['photo'];
}

// Unlink (delete) the photo from the uploads folder
if($photo != '') {
    unlink('../assets/uploads/' . $photo);
}

// Delete the record from the tbl_service table
$statement = $pdo->prepare("DELETE FROM tbl_service WHERE id=?");
$statement->execute(array($_REQUEST['id']));

// Redirect to the service list page after deletion
header('location: service.php');
?>

<?php require_once('footer.php'); ?>
