<?php require_once('header.php'); ?>

<div class = "page">
    <div class = "container">
        <div class = "row">
            <div class = "col-md-12">

                <!-- displaying the message for success -->
                <p>
                <h3 style="margin-top:20px;"><?php echo LANG_VALUE_121; ?></h3>
                <a href="dashboard.php" class="btn btn-success"><?php echo LANG_VALUE_91; ?></a>
                </p>

            </div>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html>
<head>

<!-- styling the success message -->
    <style>
        body, html {
    margin: 0;
    padding: 0;
    height: 100%;
}
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
}
</style>

</head>
<body>

<!-- including the already existing footer file here -->
    <footer>
        <?php require_once('footer.php'); ?>
    </footer>
</body>
</html>


 