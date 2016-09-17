<?php if ($testmode) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $text_testmode; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post">
    <?php foreach ($products as $product) {
    ?>
    <input type="hidden" name="<?php echo $product['name']; ?>" value="<?php echo $product['quantity'].','.$product['price']; ?>" />
    <?php } ?>
    <?php if ($discount_amount_cart) { ?>
    <input type="hidden" name="Discount" value="<?php echo $Discount; ?>" />
    <?php } ?>
    <input type="hidden" name="vendor_name" value="<?php echo $vendor_name; ?>"/>
    <input type="hidden" name="print_zero_qty" value="<?php echo $print_zero_qty; ?>"/>
    <input type="hidden" name="receipt_address" value="<?php echo $receipt_address; ?>"/>
    <input type="hidden" name="payment_reference" value="<?php echo $payment_reference; ?>"/>
    <input type="hidden" name="return_link_url" value="<?php echo $return_link_url; ?>"/>
    <input type="hidden" name="reply_link_url" value="<?php echo $reply_link_url; ?>"/>
    <input type="hidden" name="payment_alert" value="<?php echo $payment_alert; ?>"/>
    <input type="hidden" name="return_link_text" value="<?php echo $return_link_text; ?>"/>
    <input type="hidden" name="Customer_Name" value="<?php echo $Customer_Name; ?>"/>
    <input type="hidden" name="Customer_Company_Name" value="<?php echo $Customer_Company_Name; ?>"/>
    <input type="hidden" name="Customer_Street" value="<?php echo $Customer_Street; ?>"/>
    <input type="hidden" name="Customer_City" value="<?php echo $Customer_City; ?>"/>
    <input type="hidden" name="Customer_State" value="<?php echo $Customer_State; ?>"/>
    <input type="hidden" name="Customer_Post_Code" value="<?php echo $Customer_Post_Code; ?>"/>
    <input type="hidden" name="Customer_Country" value="<?php echo $Customer_Country; ?>"/>
    <?php if ($Customer_Phone) { ?>
    <input type="hidden" name="Customer_Phone" value="<?php echo $Customer_Phone; ?>"/>
    <?php } ?>
    <input type="hidden" name="information_fields" value="<?php echo $information_fields; ?>"/>
    <div class="buttons">
        <div class="pull-right">
            <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
        </div>
    </div>
</form>
