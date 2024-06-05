<?php
session_start();
ob_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
// cross site request forgery protect
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- importing style -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css"/>
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">AgriConnect-Malawi</span>
			</a>

			<nav class="navbar navbar-static-top">
				<!-- displaying admin panel options -->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>
    <!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
                            <!-- dropdown for selecting option for logout or editing profile -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>
<!-- Side Bar to Manage Shop Activities -->
  		<aside class="main-sidebar">
    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
                        <!-- admins dashboard that show statistics -->
			            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'admins.php') || ($cur_page == 'admins-add.php') || ($cur_page == 'admins-edit.php') ) {echo 'active';} ?>">
			          <a href="admins.php">
                        <!-- section for managing admins -->
					  <i class="fa fa-user"></i> <span>Admins Management</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'customer.php') || ($cur_page == 'customer-add.php') || ($cur_page == 'customer-edit.php') ) {echo 'active';} ?>">
			          <a href="customer.php">
                        <!-- section for viewing total registered customers -->
			            <i class="fa fa-users"></i> <span>Registered Customers</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'vendor.php') || ($cur_page == 'vendor-add.php') || ($cur_page == 'vendor-edit.php') ) {echo 'active';} ?>">
			          <a href="vendor.php">
                        <!-- viewing registered vendors -->
					  <i class="fa fa-user"></i> <span>Registered Vendors</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'order.php') ) {echo 'active';} ?>">
			          <a href="order.php">
                        <!-- viewing orders -->
					  		<i class="fa fa-sticky-note"></i> <span>Orders Management</span>
			          </a>
			        </li>
					
			        <li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
			          <a href="settings.php">
                        <!-- settings for managing the platform -->
			            <i class="fa fa-sliders"></i> <span>Website Settings</span>
			          </a>
			        </li>    
      			</ul>
    		</section>
  		</aside>

  	<div class="content-wrapper">