<?php
                        $product_type = apply_filters('woocommerce_in_cart_product_type', $_product->get_type(), $values, $cart_item_key); 
                        if($product_type=='subscription'){
                            echo '<div>Delivered Monthly</div>';
                        }
                        ?>
<?php
                        $product_type = $_product->get_type(); 
                        if($product_type=='subscription'){
                            echo '<div>Delivered Monthly</div>';
                        }
                        ?>						