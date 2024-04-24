<?php require_once('header.php'); ?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id = 1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);