<?php

/* 
    Created on : Oct 11, 2016, 9:58:00 AM
    Author: Tran Trong Thang
    Email: trantrongthang1207@gmail.com
    Skype: trantrongthang1207
*/

/*
 * Hien truong phone trong trang edit shipping
 */
add_action('init', 'tv_override_billing_fields', 30);
add_filter('woocommerce_shipping_fields', 'tv_override_shipping_fields');

function tv_override_shipping_fields($fields) {
    $fields['shipping_phone'] = array(
        'label' => __('Phone', 'woocommerce'),
        'placeholder' => _x('Phone', 'placeholder', 'woocommerce'),
        'required' => true,
        'class' => array('form-row-wide tvphone'),
    );
    return $fields;
}
/*
 * Validate my account
 */
add_filter( 'woocommerce_process_myaccount_field_billing_state' , 'validate_billing_state' );
function validate_billing_state() {
    $billing_state = $_POST['billing_state'];
    if ($billing_state == '') {     
        wc_add_notice( __( 'State / County is a required field.' ), 'error' );
    }
    return $billing_state ; 
} 

add_filter( 'woocommerce_process_myaccount_field_shipping_state' , 'validate_shipping_state' );
function validate_edit_address() {
    $shipping_state = $_POST['shipping_state'];
    if ($shipping_state == '') {     
        wc_add_notice( __( 'State / County is a required field.' ), 'error' );
    }
    return $shipping_state ; 
} 