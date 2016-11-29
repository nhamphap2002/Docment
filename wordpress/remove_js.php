<?php

/* 
    Created on : Nov 11, 2016, 8:28:11 AM
    Author     : Tran Trong Thang
    Email      : trantrongthang1207@gmail.com
    Skype      : trantrongthang1207
*/


add_filter( 'script_loader_tag', function ( $tag, $handle ) {

    if ( 'braintree-custom-form-checkout' !== $handle )
        return $tag;
    var_dump('change id');
    return str_replace( ' src', ' id="braintree-custom-form-checkout" src', $tag );
}, 10, 2 );




function braintree_dequeue_script() {
    if (is_cart) {
        wp_dequeue_script('braintree-custom-form-checkout');
        var_dump('dequeue');
    }
}

add_action('wp_print_scripts', 'braintree_dequeue_script', 100);
//add_action('wp_enqueue_scripts', 'braintree_dequeue_script', 20);


function wpa54064_inspect_scripts() {
    global $wp_scripts;
    foreach ($wp_scripts->queue as $handle) :
        var_dump($handle . '<br/>');
    endforeach;
    exit();
}

//add_action( 'wp_print_scripts', 'wpa54064_inspect_scripts' );