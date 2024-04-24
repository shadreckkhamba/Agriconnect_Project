<?php require_once('header.php'); ?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id = 1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $banner_checkout = $row['banner_checkout'];
    }
    ?>

    <?php
    if (!isset($_SESSION['cart_P_id'])) {
        header('location:cart.php');
        exit;
    }
    ?>

<div class = "page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
         <div class = "overlay"></div>
         <div class = "page-banner-inner">
            <h1><?php echo LANG_VALUE_22; ?></h1>
         </div>
</div>

<div class = "page">
    <div class = "container">
        <div class = "row">
            <div class = "col-md-12">
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href = "login.php" class = "btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class = "special"><?php echo LANG_VALUE_26; ?></h3>
                <div class = "cart">
                    <table class = "table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo '#' ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class = "text-right"><?php echo LANG_VALUE_82; ?></th>
                </tr>
                 <?php
                 $table_total_price = 0;
                 
                 $i = 0;
                 foreach($_SESSION['cart_p_id'] as $key => $value){
                    $i++;
                    $arr_cart_p_id[$i] = $value;
                 }

                 $i = 0;
                 foreach($_SESSION['cart_p_qty'] as $key => $value){
                    $i++;
                    $arr_cart_p_qty[$i] = $value;
                 }

                 $i = 0;
                 foreach($_SESSION['cart_p_current_price'] as $key => $value){
                    $i++;
                    $arr_cart_p_current_price[$i] = $value;
                 }

                 $i = 0;
                 foreach($_SESSION['cart_p_name'] as $key => $value){
                    $i++;
                    $arr_cart_p_name[$i] $value;
                 }

                 $i = 0;
                 foreach($_SESSION['cart_p_featured_photo'] as $key => $value){
                    $i++;
                    $arr_cart_p_featured_photo[$i] = $value;
                 }
                 ?>
                 <?php for($i = 1; $i <= count($arr_cart_p_id); $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <img src = "assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="product-image">
                        </td>
                        <td><?php echo $arr_cart_p_name[$i]; ?></td>
                        <td><?php echo "MWK " ?><?php echo number_format($arr_cart_p_current_price[$i], 2); ?></td>
                        <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                        <td class = "text-right">
                            <?php
                            $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                            $table_total_price = $table_total_price + $row_total_price;
                            ?>
                            <?php echo "MWK " ?><?php echo number_format($row_total_price, 2); ?>
                        </td>
                 </tr>
                 <?php endfor; ?>
                 <tr>
                    <th colspan = "7" class = "total-text"><?php echo LANG_VALUE_81; ?></th>
                    <th class = "total-amount"><?php echo "MWK " ?><?php echo number_format($table_total_price, 2); ?></th>
                 </tr>
                 <?php
                 $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE sca_id = 1");
                 $statement->execute();
                 $result = $statement->fetchAll(PDO:: FETCH_ASSOC);
                 foreach($result as $row){
                    $shipping_cost = 0;
                 }
                 ?>

                 <tr>
                    <td colspan = "7" class = "total-text"><?php echo "Shipping costs" ?></td>
                    <td class = "total-amount"><?php echo "MWK " ?><?php echo number_format($shipping_cost, 2); ?></td>
                 </tr>
                 <tr>
                    <th colspan = "7" class = "total-text"><?php echo LANG_VALUE_82; ?></th>
                    <th class = "total-amount">
                        <?php
                        $final_total = $table_total_price + $shipping_cost;
                        ?>
                        <?php echo "MWK " ?><?php echo number_format($final_total, 2); ?>
                    </th>
                </tr>
            </table>
        </div>

    <div  class = "col-md-9">
        <h3 class = "special"><?php echo LANG_VALUE_162; ?></h3>
        <table class = "table table-responsive table-bordered table-hover table-striped bill-address">
            <tr>
                <td><?php echo LANG_VALUE_102; ?></td>
                <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
            </tr>
            
            <tr>
                <td><?php echo LANG_VALUE_104; ?></td>
                <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
            </tr>
            
            <tr>
                <td><?php echo LANG_VALUE_105; ?></td>
                <td>
                    <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                </td>
            </tr>
            
            <tr>
                <td><?php echo "City/District"; ?></td>
                <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
            </tr>

        </table>
    </div>
  </div>
</div>

<div class = "cart-buttons">
    <ul>
        <li><a href="cart.php" class="btn btn-primary"><?php echo LANG_VALUE_21; ?></a></li>
    </ul>
</div>

<div class = "clear"></div>
<h3 class = "special"><?php echo LANG_VALUE_33; ?></h3>
<div class = "row">
    <?php
    $checkout_access = 1;
    if(
        ($_SESSION['customer']['cust_s_name']=='') ||
        ($_SESSION['customer']['cust_s_phone']=='') ||
        ($_SESSION['customer']['cust_s_address']=='') ||
        ($_SESSION['customer']['cust_s_state']=='')
    ){
        $checkout_access = 0;
    }
    ?>
    
    <?php if($checkout_access == 0): ?>
        <div  class = "col-md-12">
            <div style="color:red;font-size:22px;margin-bottom:50px;">
                You must have to fill up all the Shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">this link</a>.
            </div>
        </div>
    <?php else: ?>
        <div class = "col-md-4">
            <div class = "row">
                
              <div class="col-md-12 form-group">
                <label for=""><?php echo LANG_VALUE_34; ?> *</label>
                <select name="payment_method" class="form-control select2" id="advFieldsStatus">
                    <option value=""><?php echo LANG_VALUE_35; ?></option>
                    <option value="Bank Deposit"><?php echo LANG_VALUE_38; ?></option>
                </select>
            </div>

             <form action="payment/bank/init.php" method="post" id="bank_form">
                <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                <div class="col-md-12 form-group">
                    <label for=""><?php echo LANG_VALUE_43; ?></span></label><br>
                     <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row) {
                      echo nl2br($row['bank_detail']);
                      }
                      ?>

                </div>
                    <div class="col-md-12 form-group">
                     <label for=""><?php echo LANG_VALUE_44; ?> <br><span style="font-size:12px;font-weight:normal;">(<?php echo LANG_VALUE_45; ?>)</span></label>
                     <textarea name="transaction_info" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form3">
                    </div>
               </form>
	         </div>	                            		                        
	       </div>
	        <?php endif; ?>
         </div>            
           <?php endif; ?>
        </div>
     </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
                       