<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>View Top Level Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="top-category-add.php" class="btn btn-primary btn-sm">Add New</a>
    </div>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <!-- Table to display top level categories -->
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Top Category Name</th>
                    <th>Show on Menu?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Counter for numbering rows
                $i=0;
                // Query to select top level categories
                $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_id DESC");
                $statement->execute();
                // Fetching results
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    // Incrementing row counter
                    $i++;
                    ?>
                    <tr>
                        <!-- Displaying row number -->
                        <td><?php echo $i; ?></td>
                        <!-- Displaying top category name -->
                        <td><?php echo $row['tcat_name']; ?></td>
                        <!-- Displaying whether top category should be shown on menu -->
                        <td>
                            <?php 
                                // Checking if show_on_menu flag is set to 1
                                if($row['show_on_menu'] == 1) {
                                    echo 'Yes';
                                } else {
                                    echo 'No';
                                }
                            ?>
                        </td>
                        <td>
                            <!-- Edit button to edit top category -->
                            <a href="top-category-edit.php?id=<?php echo $row['tcat_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <!-- Delete button to delete top category -->
                            <a href="#" class="btn btn-danger btn-xs" data-href="top-category-delete.php?id=<?php echo $row['tcat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <!-- Warning message about consequences of deletion -->
                <p style="color:red;">Be careful! All products, mid level categories and end level categories under this top lelvel category will be deleted from all the tables like order table, payment table, size table, color table, rating table etc.</p>
            </div>
            <div class="modal-footer">
                <!-- Button to cancel deletion -->
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <!-- Button to confirm deletion -->
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
