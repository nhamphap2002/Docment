<?php

add_action('wp_enqueue_scripts', 'my_enqueue_assets');

function my_enqueue_assets() {

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('fgc-script', get_stylesheet_directory_uri() . '/assets/js/tvscript.js', array('jquery'));
}

add_action('woocommerce_checkout_process', 'is_phone');

function is_phone() {
    $phone = $_REQUEST['billing_phone'];

    if (0 == strlen(trim(preg_replace('/[\s\#0-9_\-\+\(\)]/', '', $phone)))) {
        if (strlen($phone) < 8) {
            // your function's body above, and if error, call this wc_add_notice
            wc_add_notice(__('<strong>Phone</strong> is a required field.'), 'error');
        }
    }
}
