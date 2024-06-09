<?php require_once('header.php'); ?>  <!-- Includes the header file -->

<section class="content-header">
	<div class="content-header-left">
		<h1>View Products</h1> <!-- Page heading -->
	</div>
	<div class="content-header-right">
		<a href="product-add.php" class="btn btn-primary btn-sm">Add Product</a> <!-- Button to add a new product -->
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="10">#</th> <!-- Column for serial number -->
								<th>Photo</th> <!-- Column for product photo -->
								<th width="160">Product Name</th> <!-- Column for product name -->
								<th width="60">Old Price</th> <!-- Column for old price -->
								<th width="60">(C) Price</th> <!-- Column for current price -->
								<th width="60">Quantity</th> <!-- Column for product quantity -->
								<th>Featured?</th> <!-- Column to indicate if the product is featured -->
								<th>Active?</th> <!-- Column to indicate if the product is active -->
								<th>Category</th> <!-- Column for product category -->
								<th width="80">Action</th> <!-- Column for action buttons (Edit, Delete) -->
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0; // Initialize counter
							$statement = $pdo->prepare("SELECT
														t1.p_id,
														t1.p_name,
														t1.p_old_price,
														t1.p_current_price,
														t1.p_qty,
														t1.p_featured_photo,
														t1.p_is_featured,
														t1.p_is_active,
														t1.ecat_id,
														t2.ecat_id,
														t2.ecat_name,
														t3.mcat_id,
														t3.mcat_name,
														t4.tcat_id,
														t4.tcat_name
							                           	FROM tbl_product t1
							                           	JOIN tbl_end_category t2
							                           	ON t1.ecat_id = t2.ecat_id
							                           	JOIN tbl_mid_category t3
							                           	ON t2.mcat_id = t3.mcat_id
							                           	JOIN tbl_top_category t4
							                           	ON t3.tcat_id = t4.tcat_id
							                           	ORDER BY t1.p_id DESC
							                           	"); // SQL query to fetch product details and category names
							$statement->execute(); // Execute the query
							$result = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
							foreach ($result as $row) { // Loop through each product
								$i++; // Increment counter
								?>
								<tr>
									<td><?php echo $i; ?></td> <!-- Display serial number -->
									<td style="width:82px;"><img src="../assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width:80px;"></td> <!-- Display product photo -->
									<td><?php echo $row['p_name']; ?></td> <!-- Display product name -->
									<td>MWK <?php echo $row['p_old_price']; ?></td> <!-- Display old price -->
									<td>MWK <?php echo $row['p_current_price']; ?></td> <!-- Display current price -->
									<td><?php echo $row['p_qty']; ?></td> <!-- Display quantity -->
									<td>
										<?php if($row['p_is_featured'] == 1) {echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';} else {echo '<span class="badge badge-success" style="background-color:red;">No</span>';} ?> <!-- Display if the product is featured -->
									</td>
									<td>
										<?php if($row['p_is_active'] == 1) {echo '<span class="badge badge-success" style="background-color:green;">Yes</span>';} else {echo '<span class="badge badge-danger" style="background-color:red;">No</span>';} ?> <!-- Display if the product is active -->
									</td>
									<td><?php echo $row['tcat_name']; ?><br><?php echo $row['mcat_name']; ?><br><?php echo $row['ecat_name']; ?></td> <!-- Display category names -->
									<td>										
										<a href="product-edit.php?id=<?php echo $row['p_id']; ?>" class="btn btn-primary btn-xs">Edit</a> <!-- Edit button -->
										<a href="#" class="btn btn-danger btn-xs" data-href="product-delete.php?id=<?php echo $row['p_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  <!-- Delete button with confirmation modal -->
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

<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> <!-- Close button -->
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4> <!-- Modal title -->
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p> <!-- Confirmation message -->
                <p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p> <!-- Warning message -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <!-- Cancel button -->
                <a class="btn btn-danger btn-ok">Delete</a> <!-- Confirm delete button -->
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?> <!-- Includes the footer file -->
