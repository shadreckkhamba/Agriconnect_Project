<?php require_once('header.php'); ?>

<?php
// retrieving order details
        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
        	if($row['payment_method'] == 'Bank Deposit'):
				$payment_details = '
Transaction Details: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Customer Name: '.$row['customer_name'].'<br>
Customer Email: '.$row['customer_email'].'<br>
Payment Method: '.$row['payment_method'].'<br>
Payment Date: '.$row['payment_date'].'<br>
Payment Details: <br>'.$payment_details.'<br>
Paid Amount: '.$row['paid_amount'].'<br>
Payment Status: '.$row['payment_status'].'<br>
Shipping Status: '.$row['shipping_status'].'<br>
Payment Id: '.$row['payment_id'].'<br>
            ';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Product Name: '.$row['product_name'].'<br>
Quantity: '.$row['quantity'].'<br>
Unit Price: '.$row['unit_price'].'<br>
            ';
        }
?>

<section class="content-header">
	<div class="content-header-left">
        <!-- viewing the orders that have been placed by different customers from products of different vendors -->
		<h1>View Orders</h1>
	</div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
            <!-- displaying table for the order information -->
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
                    <th>Customer</th>
			        <th>Product Details</th>
                    <th>
                    	Payment Information
                    </th>
                    <th>Paid Amount</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr class="<?php if($row['payment_status']=='Pending'){echo 'bg-r';}else{echo 'bg-g';} ?>">
	                    <td><?php echo $i; ?></td>
	                    <td>
                        <?php
                                $statement2 = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email='{$row['customer_email']}'");
                                $statement2->execute();
                                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result2 as $row2){
                                    echo '<b>Name:</b> '.$row2['cust_name'];
                                    echo '<br><b>Email:</b> '.$row2['cust_email'];
                                    echo '<br><b>Phone: </b> '.$row2['cust_phone'];
                                    echo '<br><b>City/District: </b> '.$row2['cust_s_city'];
                                    echo '<br><b>Address: </b> '.$row2['cust_s_address'];
                                    
                                }
                            ?>
                            
                        </td>
                        <td>
                        <?php
                        $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                        $statement1->execute(array($row['payment_id']));
                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result1 as $row1) {
                            // Fetch user details from tbl_user
                            $user_statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=?");
                            $user_statement->execute(array($row1['uploader']));
                            $user_result = $user_statement->fetch(PDO::FETCH_ASSOC);
                            
                            // Display order details and user details
                            echo '<b>Product:</b> ' . $row1['product_name'].', ';
                            echo '<b>Quantity:</b> ' . $row1['quantity'].', ';
                            echo '<b>Unit Price: </b> MWK ' . number_format($row1['unit_price'],2) .'<br>';
                            
                            // Check if user details are found
                            if ($user_result) {
                                
                                echo '<b>Vendor Name:</b> ' . $user_result['full_name'].'<br>';
                                echo '<b>Vendor Phone:</b> ' . $user_result['phone'].'<br>';
                                echo '<b>Vendor Email:</b> ' . $row1['uploader'].'<br>';
                            } else {
                                // If user details are not found, display a message
                                echo ', <b>User details not found for email:</b> ' . $row1['uploader'];
                            }
                            
                            echo '<br>';
                        }
                        ?>


                        </td>
                        <td>
                        	<?php elseif($row['payment_method'] == 'Bank Deposit'): ?>
                        		<b>Payment Method:</b> <?php echo '<span style="color:red;"><b>'.$row['payment_method'].'</b></span>'; ?><br>
                        		<b>Payment Id:</b> <?php echo $row['payment_id']; ?><br>
								<b>Date:</b> <?php echo $row['payment_date']; ?><br>
                        		<b>Transaction Information:</b> <br><?php echo $row['bank_transaction_info']; ?><br>
                        	<?php endif; ?>
                        </td>
                        <td>MWK <?php echo number_format($row['paid_amount'], 2); ?></td>
                        <td>
                            <?php echo $row['payment_status']; ?>
                            <br><br>
                            <?php
                                if($row['payment_status']=='Pending'){
                                    $paymentId= $row['payment_id'];


                                    $statement2 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                    $statement2->execute(array($paymentId));
                                    $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);

                                    // Array to store unique 'uploader' values
                                    $uploaders = array();

                                    foreach($result2 as $row2){
                                        // Add uploader value to the array
                                        $uploaders[] = $row2['uploader'];
                                    }

                                    // Count the number of unique values
                                    $unique_uploaders = array_unique($uploaders);
                                    $count_unique_uploaders = count($unique_uploaders);

                                    if ($count_unique_uploaders >= 2) { ?>
                                        <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                    <?php } else {
                                        ?>
                                        <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                        <?php
                                    }

                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $row['shipping_status']; ?>
                            <br><br>
                            <?php
                            if($row['payment_status']=='Completed') {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Mark Complete</a>
                                    <?php
                                }
                            }
                            ?>
                        </td>
	                    <td>
                            <a href="#" class="btn btn-danger btn-xs" data-href="order-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete" style="width:100%;">Delete</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div> 

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>