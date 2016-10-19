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