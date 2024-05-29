<?php require_once('header.php'); ?>

<?php
// Assuming you have already established a database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password']; // Remember to hash this password before inserting into the database for security reasons

    // Insert data into the database
    $statement = $pdo->prepare("INSERT INTO tbl_user (full_name, email, phone, password, photo, role, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([$full_name, $email, $phone, md5($password),'user-3.jpg', 'admin','Active']);

    // Redirect back to the previous page
    $success_message = 'New Admin is added successfully.';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <style>
        /* Custom CSS for form padding */
        .form-container {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
            
            <a href="javascript:history.back()" class="btn btn-secondary mb-3">Back</a>
            <h2 class="text-center mb-4">Add Admin</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="full_name">Full Name <span style="color:red">*</span></label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address <span style="color:red">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number <span style="color:red">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="password">Password <span style="color:red">*</span></label>
                    
                        <input type="password" class="form-control" id="password" name="password" required>
                        
                    
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional if you require JS functionality) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // JavaScript to toggle password visibility
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordInput = document.getElementById("password");
        var toggleButton = document.getElementById("togglePassword");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            toggleButton.textContent = "Show";
        }
    });
</script>

</body>
</html>
