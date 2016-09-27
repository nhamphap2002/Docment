Them mot action
add_action( 'woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20 );
Goi mot action
<?php do_action('woocommerce_checkout_payment'); ?>

Ghi de mot action
add_action('init', 'custom_remove_storefront_secondary_navigation', 30);

function custom_remove_storefront_secondary_navigation() {
    remove_action('storefront_header', 'storefront_secondary_navigation', 30);
    add_action('storefront_header', 'custom_storefront_secondary_navigation', 30);
}

Loai bo woocommerce_checkout_payment duoc hook vao woocommerce_checkout_order_review
sau do no duoc hook vao woocommerce_checkout_payment
add_action('init', 'custom_woocommerce_checkout_payment', 30);

function custom_woocommerce_checkout_payment() {
    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
    add_action('woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20);
}


<div class="tvpayment">
            <?php do_action('woocommerce_checkout_payment'); ?>
        </div>

Thay doi vi tri hient hi cua mot khoi chuc nang
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_after_order_notes', 'woocommerce_checkout_payment', 20 );