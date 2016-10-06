<?php

/* 
    Created on : Oct 4, 2016, 8:10:04 AM
    Author: Tran Trong Thang
    Email: trantrongthang1207@gmail.com
    Skype: trantrongthang1207
*/

add_action('woocommerce_checkout_process', 'is_phone');

function is_phone() {
    $phone = $_REQUEST['billing_phone'];

    if (0 == strlen(trim(preg_replace('/[\s\#0-9_\-\+\(\)]/', '', $phone)))) {
        if (strlen($phone) < 8) {
            // your function's body above, and if error, call this wc_add_notice
            wc_add_notice(__('Your phone number has atleast 8 integers.'), 'error');
        }
    }
}



