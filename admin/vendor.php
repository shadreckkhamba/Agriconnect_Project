<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Vendors</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="10">#</th>
								<th width="180">Name</th>
								<th width="150">Email Address</th>
								<th width="180">District</th>
                                <!-- payment method and details for sending the payment to the vendor -->
								<th width="180">Payment Method</th>
								<th width="180">Payment Details</th>
								<th>Status</th>
								<th width="100">Change Status</th>
								<th width="100">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php
$i=0;
$statement = $pdo->prepare("SELECT * 
                            FROM tbl_customer WHERE acc_type='vendor'
                           ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                        
foreach ($result as $row) {
    $i++;
    $email=$row['cust_email'];
    $statement2 = $pdo->prepare("SELECT status, payment_type, payment_details 
                                FROM tbl_user WHERE email=:email
                               ");
    $statement2->bindParam(':email', $email); // Bind parameter to avoid SQL injection
    $statement2->execute();
    $result2 = $statement2->fetch(PDO::FETCH_ASSOC); // Assuming one row for each email

    ?>
    <tr class="<?php if($row['cust_status']==1 && $result2['status']=='Active') {echo 'bg-g';}else {echo 'bg-r';} ?>">
        <td><?php echo $i; ?></td>
        <td><?php echo $row['cust_name']; ?></td>
        <td><?php echo $row['cust_email']; ?></td>
        <td>
            <?php echo $row['cust_city']; ?><br>
        </td>
		<!-- Display additional user information -->
        <td><?php echo $result2['payment_type']; ?></td>
        <td><?php echo $result2['payment_details']; ?></td>
        <td><?php if($row['cust_status']==1) {echo 'Active';} else {echo 'Inactive';} ?></td>
        <td>
            <a href="vendor-change-status.php?id=<?php echo $row['cust_id']; ?>" class="btn btn-success btn-xs">Change Status</a>
        </td>
        <td>
            <a href="#" class="btn btn-danger btn-xs" data-href="vendor-delete.php?id=<?php echo $row['cust_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
        </td>
        
    </tr>
    <?php
}
?>
							
						</tbody>
					</table>
				</div>
			</div>
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
                <p>Are you sure want to delete this vendor?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>