<?php

/**
 * Description: Redirect to checkout page after press "BUY NOW" button
 
 */
add_filter('add_to_cart_redirect', 'fgc_redirect_to_checkout');

function fgc_redirect_to_checkout() {
    return WC()->cart->get_checkout_url();
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );
function woo_custom_cart_button_text() {
    return __( 'Buy now', 'woocommerce' );
}


/**
 * Description: Limit Quantity in Add to cart and Checkout page
 
 */
add_filter('woocommerce_quantity_input_args', 'fgc_woocommerce_quantity_input_args', 10, 2);

function fgc_woocommerce_quantity_input_args($args, $product) {
    $args['max_value'] = 3;   // Maximum value
    return $args;
}

add_action('woocommerce_check_cart_items', 'fgc_check_maximum_quantity');

function fgc_check_maximum_quantity() {
    if (is_cart() || is_checkout()) {
        global $woocommerce;
        $max_quantity = 3;

        $arrayItems = $woocommerce->cart->get_cart();
        if (!empty($arrayItems)) {
            foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
                $currentQuantity = $cart_item['quantity'];
                if ($currentQuantity > $max_quantity)
                    $woocommerce->cart->set_quantity($cart_item_key, $max_quantity);
            }
        }
    }
}



/* Check compability */
function check_compability($petrol_time, $diesel_time, $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no) {
    if ($fuel === $petrol) {
        if (in_array($year, yrange($petrol_time))) {
            $_POST['item_meta'][$compatible_yes] = 'Confirmed';
            return array();
        } else {
            $_POST['item_meta'][$compatible_no] = '';
            add_filter('frm_main_feedback', 'frm_main_feedback', 20, 3);
        }
    } else if ($fuel === $diesel) {
        if (in_array($year, yrange($diesel_time))) {
            $_POST['item_meta'][$compatible_yes] = 'Confirmed';
            return array();
        } else {
            $_POST['item_meta'][$compatible_no] = '';
            add_filter('frm_main_feedback', 'frm_main_feedback', 20, 3);
        }
    } else {
        $_POST['item_meta'][$compatible_no] = '';
        add_filter('frm_main_feedback', 'frm_main_feedback', 20, 3);
    }
}

/* Display success message */
function frm_main_feedback($message, $form, $entry_id) {
    $message = '<div class="frm_message"><p>Hi, we will check your car and in 24hs we will get back to you!!</p></div>';
    return $message;
}

/* Check year range */
function yrange($year_number) {
    return range($year_number, date('Y'));
}