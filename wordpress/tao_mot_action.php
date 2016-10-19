<!--Them mot action-->
<?php
add_action('woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20);
?>
<!--Goi mot action-->
<?php do_action('woocommerce_checkout_payment'); ?>

<!--Ghi de mot action-->
<?php
add_action('init', 'custom_remove_storefront_secondary_navigation', 30);

function custom_remove_storefront_secondary_navigation() {
    remove_action('storefront_header', 'storefront_secondary_navigation', 30);
    add_action('storefront_header', 'custom_storefront_secondary_navigation', 30);
}

function custom_storefront_secondary_navigation() {
    global $woocommerce;
    ?>
    <nav aria-label="Secondary Navigation" role="navigation" class="secondary-navigation">
        <a class="menu-toggle-user" href="">&nbsp;</a>
        <div class="menu-top-nav-links-container
                <?php echo is_user_logged_in() ? 'islogin' : '' ?>">
            <ul class="menu" id="menu-top-nav-links">
                <?php
                if (is_user_logged_in()) {
                    ?>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-14" id="menu-item-14">
                        <span class="icon_user">&nbsp;</span>
                        <a href="
        <?php echo get_site_url(); ?>/my-account/">My account</a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-13" id="menu-item-13">
                        <a href="<?php echo wp_logout_url(home_url() . "/?openlogin=true"); ?>">Logout</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-14" id="menu-item-14">
                        <a id="show_login" href="
        <?php echo get_site_url(); ?>/wp-login.php?action=register">Register</a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-13" id="menu-item-13">
                        <a id="show_login" href="
        <?php echo get_site_url(); ?>/wp-login.php">Login</a>
                    </li>

                <?php }
                ?>
            </ul>
            <a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" id="show_signup"></a>
        </div>
    </nav>
    <?php
}
?>
<!--Loai bo woocommerce_checkout_payment duoc hook vao woocommerce_checkout_order_review
sau do no duoc hook vao woocommerce_checkout_payment-->
<?php
add_action('init', 'custom_woocommerce_checkout_payment', 30);

function custom_woocommerce_checkout_payment() {
    remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
    add_action('woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20);
}
?>
<div class="tvpayment">
<?php do_action('woocommerce_checkout_payment'); ?>
</div>

<!--Thay doi vi tri hient hi cua mot khoi chuc nang-->
<?php
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_after_order_notes', 'woocommerce_checkout_payment', 20);
?>