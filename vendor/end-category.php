Sure, here are comments added to your code without making any changes to the existing structure:

```php
<?php require_once('header.php'); // Include the header file ?>

<!-- Section for content header -->
<section class="content-header">
	<div class="content-header-left">
		<h1>View End Level Categories</h1> <!-- Page title -->
	</div>
	<div class="content-header-right">
		<a href="end-category-add.php" class="btn btn-primary btn-sm">Add New</a> <!-- Button to add a new end category -->
	</div>
</section>

<!-- Main content section -->
<section class="content">

  <div class="row">
    <div class="col-md-12">

      <div class="box box-info">
        
        <!-- Table responsive box -->
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th> <!-- Serial number -->
			        <th>End Level Category Name</th>
                    <th>Mid Level Category Name</th>
                    <th>Top Level Category Name</th>
			        <th>Action</th> <!-- Edit/Delete actions -->
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0; // Initialize counter
            	$statement = $pdo->prepare("SELECT * 
                                    FROM tbl_end_category t1
                                    JOIN tbl_mid_category t2
                                    ON t1.mcat_id = t2.mcat_id
                                    JOIN tbl_top_category t3
                                    ON t2.tcat_id = t3.tcat_id
                                    ORDER BY t1.ecat_id DESC
                                    "); // Prepare SQL query to fetch end categories with their respective mid and top categories
            	$statement->execute(); // Execute the query
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);	// Fetch all results						
            	foreach ($result as $row) { // Loop through each result
            		$i++; // Increment counter
            		?>
					<tr>
	                    <td><?php echo $i; ?></td> <!-- Display counter -->
	                    <td><?php echo $row['ecat_name']; ?></td> <!-- Display end category name -->
                        <td><?php echo $row['mcat_name']; ?></td> <!-- Display mid category name -->
                        <td><?php echo $row['tcat_name']; ?></td> <!-- Display top category name -->
	                    <td>
	                        <a href="end-category-edit.php?id=<?php echo $row['ecat_id']; ?>" class="btn btn-primary btn-xs">Edit</a> <!-- Edit button -->
	                        <a href="#" class="btn btn-danger btn-xs" data-href="end-category-delete.php?id=<?php echo $row['ecat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a> <!-- Delete button with confirmation modal -->
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div> <!-- End of box body -->
      </div> <!-- End of box -->

</section> <!-- End of content section -->

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
                <p style="color:red;">Be careful! All products under this end category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p> <!-- Warning message -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <!-- Cancel button -->
                <a class="btn btn-danger btn-ok">Delete</a> <!-- Delete button -->
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); // Include the footer file ?>
```