<?php
if (  ! function_exists( 'woocommerce_checkout_payment' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function woocommerce_checkout_payment() {
		echo '<h3>' . get_the_title() . '</h3>';
	}
}
//De them mot vi tri sau nay chi can goi 
add_action( 'woocommerce_checkout_before_billing', 'woocommerce_checkout_payment', 20 );
//la no se hien thi noi dung o vi tri ta dat
 do_action('woocommerce_checkout_before_billing'); ?>