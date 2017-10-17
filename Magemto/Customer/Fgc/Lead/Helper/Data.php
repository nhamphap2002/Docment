<?php

/**
 * Custom Product Preview
 *
 * @category:    Fgc
 * @package:     Fgc_Lead
 */
class Fgc_Lead_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getPreOrNext($_product, $type='pre') {
        if (!$_product->getCategoryIds())
            return; // Don't show Previous and Next if product is not in any category

        $cat_ids = $_product->getCategoryIds(); // get all categories where the product is located
        $cat = Mage::getModel('catalog/category')->load($cat_ids[0]); // load first category

        $order = Mage::getStoreConfig('catalog/frontend/default_sort_by');
        $direction = 'asc'; // asc or desc

        $category_products = $cat->getProductCollection()->addAttributeToSort($order, $direction);
        $category_products->addAttributeToFilter('status', 1); // 1 or 2
        $category_products->addAttributeToFilter('visibility', 4); // 1.2.3.4

        $cat_prod_ids = $category_products->getAllIds(); // get all products from the category
        $_product_id = $_product->getId();

        $_pos = array_search($_product_id, $cat_prod_ids); // get position of current product
        $_next_pos = $_pos + 1;
        $_prev_pos = $_pos - 1;

// get the next product url
        if (isset($cat_prod_ids[$_next_pos])) {
            $_next_prod = Mage::getModel('catalog/product')->load($cat_prod_ids[$_next_pos]);
        } else {
            $_next_prod = Mage::getModel('catalog/product')->load(reset($cat_prod_ids));
        }
// get the previous product url
        if (isset($cat_prod_ids[$_prev_pos])) {
            $_prev_prod = Mage::getModel('catalog/product')->load($cat_prod_ids[$_prev_pos]);
        } else {
            $_prev_prod = Mage::getModel('catalog/product')->load(end($cat_prod_ids));
        }
        if($type == 'pre'){
            return $_prev_prod;
        }elseif($type == 'next'){
            return $_next_prod;
        }else{
            return;
        }
    }

    public function getPreviousProduct() {
        $prodId = Mage::registry('current_product')->getId();

        $catArray = Mage::registry('current_category');

        if ($catArray) {
            $catArray = $catArray->getProductsPosition();
            print_r($catArray);
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);

            $productId = $values[$keys[$prodId] - 1];

            $product = Mage::getModel('catalog/product');

            if ($productId) {
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }

        return false;
    }

    public function getNextProduct() {
        $prodId = Mage::registry('current_product')->getId();

        $catArray = Mage::registry('current_category');

        if ($catArray) {
            $catArray = $catArray->getProductsPosition();
            $keys = array_flip(array_keys($catArray));
            $values = array_keys($catArray);

            $productId = $values[$keys[$prodId] - 1];

            $product = Mage::getModel('catalog/product');

            if ($productId) {
                $product->load($productId);
                return $product->getProductUrl();
            }
            return false;
        }

        return false;
    }

}
