<?php

/*
  Created on : Sep 24, 2016, 8:54:48 AM
  Author: Tran Trong Thang
  Email: trantrongthang1207@gmail.com
  Skype: trantrongthang1207
 */

/*
 * Dinh nghia mot ham de khoi trong action
 */
if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop. By default this is an H3.
     */
    function woocommerce_template_loop_product_title() {
        echo '<h3>' . get_the_title() . get_the_title() . '</h3>';
    }

}

/*
 * Gan ham da duoc dinh nghia vao mot action cu the
 */
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

/*
 * Thuc hien goi ham da duoc dinh nghia o tren thong qua action
 */
do_action('woocommerce_shop_loop_item_title');


/*
 * De override chuc nang cua action nay ta lam nhu sau
 */
/* CREATE the new function */
/*
 * Thuc hien loai bo ham da duoc dinh nghia cho action truoc do 
 */
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

/*
 * Dinh nghia mot ham moi de ghi de ham truoc do
 */

function woocommerce_template_loop_product_title_tag() {
    global $product;
    $arrTitle = explode('  ', get_the_title());

    echo '<h3 style="color: red;" class="loop-title" >' . $arrTitle[0] . '<span>' . $arrTitle[1] . '</span></h3>';
}

/*
 * Thuc hien gan lai ham duoc dinh nghia moi cho action 
 */
/* ADD new loop-title-with sku action      */
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title_tag', 10);

