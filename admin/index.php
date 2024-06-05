<?php require_once('header.php'); ?>

<!-- displaying the dashboard word -->
<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1' AND acc_type='customer'");
$statement->execute();
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_status='1' AND acc_type='vendor'");
$statement->execute();
$total_vendors = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active='1'");
$statement->execute();
$total_subscriber = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE role='admin'");
$statement->execute();
$total_admins = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status=?");
$statement->execute(array('Completed'));
$total_shipping_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$total_order_pending = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=? AND shipping_status=?");
$statement->execute(array('Completed','Pending'));
$total_order_complete_shipping_pending = $statement->rowCount();
?>

<section class="content">
<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3><?php echo $total_product; ?></h3>
                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-cart"></i>
                </div>               
              </div>
            </div>

			<div class="col-lg-3 col-xs-6">
				<!-- total number of admins -->
				<div class="small-box bg-red">
				  <div class="inner">
					<h3><?php echo $total_admins; ?></h3>
					<p>Total Admins</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				  </div>  
				</div>
			</div>

			<div class="col-lg-3 col-xs-6">
				<!-- total vendors -->
				<div class="small-box bg-green">
				  <div class="inner">
					<h3><?php echo $total_vendors; ?></h3>
					<p>Active Vendors</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				  </div>				  
				</div>
			  </div>

			<div class="col-lg-3 col-xs-6">
				<!-- display total customers -->
				<div class="small-box bg-orange">
				  <div class="inner">
					<h3><?php echo $total_customers; ?></h3>
					<p>Active Customers</p>
				  </div>
				  <div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				  </div>				  
				</div>
			</div>
			  
			<div class="col-lg-3 col-xs-6">
              <!-- display pending orders in card form -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $total_order_pending; ?></h3>
                  <p>Pending Payment</p>
                </div>
                <div class="icon">
				<i class="ionicons ion-cash"></i>
                </div>          
              </div>
            </div>

			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $total_order_complete_shipping_pending; ?></h3>
                  <p>Pending Delivery</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>      
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $total_order_completed; ?></h3>
                  <p>Payment Competed</p>
                </div>
                <div class="icon">
					<i class="ionicons ion-cash"></i>
                </div>              
              </div>
            </div>

			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3><?php echo $total_shipping_completed; ?></h3>
                  <p>Delivery Completed</p>
                </div>
                <div class="icon">
                  <i class="ionicons ion-android-checkbox-outline"></i>
                </div>          
              </div>
            </div> 

		</div>
		  
</section>

<!-- include footer below the page -->
<?php require_once('footer.php'); ?>