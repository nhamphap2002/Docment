<?php
/*
 * get vaule config admin
 * firecheckout ten module
 * general tag chua field payment_method
 * ten field payment_method
 */
echo $defaultMethod = Mage::getStoreConfig('firecheckout/general/payment_method');
?> 
<script type="text/javascript">
    //<![CDATA[
    /*
     * Set payment default
     */
    payment.init();
    payment.switchMethod('<?php echo $defaultMethod ?>');
    jQuery('.button-' + '<?php echo $defaultMethod ?>').click();
    //]]>
</script>