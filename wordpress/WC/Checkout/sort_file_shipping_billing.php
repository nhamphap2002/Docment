<?php

/* 
    Created on : Oct 11, 2016, 9:22:44 AM
    Author: Tran Trong Thang
    Email: trantrongthang1207@gmail.com
    Skype: trantrongthang1207
*/

// Hook in
    add_filter('woocommerce_checkout_fields', 'custom_override_fields');

// Our hooked in function - $fields is passed via the filter!
    function custom_override_fields($fields) {
        unset($fields['billing']['billing_company']);
        unset($fields['shipping']['shipping_company']);
        unset($fields['shipping']['shipping_address_2']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_email']);

        return $fields;
    }

    add_filter("woocommerce_checkout_fields", "order_billing_fields");

    function order_billing_fields($fields) {

        $fields['billing']['billing_city'] = array(
            'label' => __('City', 'woocommerce'),
            'placeholder' => _x('City', 'placeholder', 'woocommerce'),
            'required' => true,
        );

        $fields['billing']['billing_email'] = array(
            'label' => __('Email', 'woocommerce'),
            'type' => 'email',
            'placeholder' => _x('Email', 'placeholder', 'woocommerce'),
            'required' => true,
            'class' => array('form-row-wide'),
            'clear' => true
        );

        $order = array(
            "billing_first_name",
            "billing_last_name",
            "billing_address_1",
            "billing_country",
            "billing_city",
            "billing_state",
            "billing_postcode",
            "billing_phone",
            "billing_email"
        );
        foreach ($order as $field) {
            $ordered_fields[$field] = $fields["billing"][$field];
        }
        unset($fields['order']['order_comments']);

        $fields["billing"] = $ordered_fields;
        return $fields;
    }

    add_filter("woocommerce_checkout_fields", "order_shipping_fields");

    function order_shipping_fields($fields) {
        $fields['shipping']['shipping_phone'] = array(
            'label' => __('Phone', 'woocommerce'),
            'placeholder' => _x('Phone', 'placeholder', 'woocommerce'),
            'required' => false,
            'class' => array('form-row-wide'),
            'clear' => true
        );
        $fields['shipping']['shipping_email'] = array(
            'label' => __('Email', 'woocommerce'),
            'type' => 'email',
            'placeholder' => _x('Email', 'placeholder', 'woocommerce'),
            'required' => true,
            'class' => array('form-row-wide'),
            'clear' => true
        );

        $fields['shipping']['shipping_city'] = array(
            'label' => __('City', 'woocommerce'),
            'placeholder' => _x('City', 'placeholder', 'woocommerce'),
            'required' => true,
        );

        $order = array(
            "shipping_first_name",
            "shipping_last_name",
            "shipping_address_1",
            "shipping_country",
            "shipping_city",
            "shipping_state",
            "shipping_postcode",
            "shipping_phone",
            "shipping_email"
        );
        foreach ($order as $field) {
            $ordered_fields[$field] = $fields["shipping"][$field];
        }
        unset($fields['order']['order_comments']);

        $fields["shipping"] = $ordered_fields;
        return $fields;
    }

    add_filter('woocommerce_checkout_get_value', 'fgc_set_shipping_email', 1, 2);

    function fgc_set_shipping_email($value, $input) {
        if ($input === 'shipping_email') {
            if ($value == null) {
                $current_user = wp_get_current_user();
                if ($current_user) {
                    return $current_user->user_email;
                }
            }
        }
        return $value;
    }
