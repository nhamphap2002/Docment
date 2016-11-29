<?php

/* 
 * override information address on checkout page
 */

add_action('init', 'tv_override_shipping_fields', 30);
add_filter('woocommerce_shipping_fields', 'tv_override_shipping_fields');

function tv_override_shipping_fields($fields) {
    $fields = array(
        'shipping_first_name' => array(
            'label' => __('Name', 'woocommerce'),
            'placeholder' => _x('Name', 'placeholder', 'woocommerce'),
            'required' => true,
        ),
        'shipping_last_name' => array(
            'label' => __('Surname', 'woocommerce'),
            'placeholder' => _x('Surname', 'placeholder', 'woocommerce'),
            'required' => true,
            'clear' => true
        ),
        'shipping_address_1' => array(
            'label' => __('Street address', 'woocommerce'),
            'placeholder' => _x('Street address', 'placeholder', 'woocommerce'),
            'required' => true,
        ),
        'shipping_country' => array(
            'type' => 'country',
            'label' => __('Country', 'woocommerce'),
            'required' => true,
        ),
        'shipping_state' => array(
            'type' => 'state',
            'label' => __('State / County', 'woocommerce'),
            'required' => true,
            'validate' => array('state'),
            'placeholder' => _x('Select a region', 'placeholder', 'woocommerce'),
        ),
        'shipping_city' => array(
            'label' => __('City', 'woocommerce'),
            'placeholder' => _x('City', 'placeholder', 'woocommerce'),
            'required' => true,
        ),
        'shipping_postcode' => array(
            'label' => __('Postcode / ZIP', 'woocommerce'),
            'required' => true,
            'placeholder' => _x('Postcode', 'placeholder', 'woocommerce'),
            'clear' => true,
        ),
        'shipping_phone' => array(
            'label' => __('Phone', 'woocommerce'),
            'placeholder' => _x('Phone', 'placeholder', 'woocommerce'),
            'required' => true,
            'class' => array('form-row-wide tvphone'),
        )
    );
    return $fields;
}

//Add filed form name biling or shipping to myaccount edit address form

add_action('woocommerce_before_edit_address_form_shipping', 'add_shipping_name_field_to_form');
add_action('woocommerce_before_edit_address_form_billing', 'add_billing_name_field_to_form');


add_action('init', 'tv_override_billing_fields', 30);
add_filter('woocommerce_billing_fields', 'tv_override_billing_fields');

function tv_override_billing_fields($fields) {
    $fields['billing_state']['placeholder'] = _x('Select a region', 'placeholder', 'woocommerce');
    return $fields;
}