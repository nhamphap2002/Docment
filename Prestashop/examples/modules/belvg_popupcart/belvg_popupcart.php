<?php

/*
 * 2007-2012 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 *         DISCLAIMER   *
 * *************************************** */
/* Do not edit or add to this file if you wish to upgrade Prestashop to newer
 * versions in the future.
 * ****************************************************
 * @package    belvg_popupcart
 * @author     Dzianis Yurevich (dzianis.yurevich@gmail.com)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class belvg_popupcart extends Module {

    const DEF_COUNT = 4;

    public function __construct() {
        $this->name = 'belvg_popupcart';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'BelVG';
        $this->need_instance = 0;
        $this->module_key = '4018b590282ac474b5695c65a12352b9';

        parent::__construct();

        $this->displayName = $this->l('Add To Cart Popup');
        $this->description = $this->l('Add To Cart Popup');
    }

    public function install() {
        Configuration::updateValue('DY_POPUPCART_NBR', self::DEF_COUNT);
        return (parent::install() && $this->registerHook('displayHeader')
                );
    }

    public function uninstall() {
        Configuration::deleteByName('DY_POPUPCART_NBR');
        return parent::uninstall();
    }

    public function hookDisplayHeader() {
        $this->context->controller->addCSS($this->_path . 'css/popupaddtocart.css', 'all');
        $this->context->controller->addJS($this->_path . 'js/popupaddtocart.js', 'all');
        $this->context->controller->addJS($this->_path . 'js/pproduct.js', 'all');
        $this->context->controller->addCSS(_PS_CSS_DIR_ . 'jquery.fancybox-1.3.4.css', 'screen');
        $this->context->controller->addJqueryPlugin(array('fancybox'));
        global $smarty;
        $url = $smarty->tpl_vars['base_dir']->value;
        if (Configuration::get('PS_SSL_ENABLED') == 1) {
            $url_base = str_replace("http://", "https://", $url);
        } else {
            $url_base = $url;
        }
        $this->smarty->assign(array(
            'url_base' => $url_base,
            'id_lang' => $this->context->language->id
        ));
        return $this->display(__FILE__, 'definedjs.tpl');
    }

    /**
     * Ham phuc vu cho request Ajax
     * @global type $smarty
     * @param type $params
     * @return type
     */
    public function processDataForPopup($params) {
        global $smarty;
        $id_language = $this->context->language->id;
        $id_product = $_REQUEST['id_product'];
        $accessories = $this->getAccessories($id_language, $id_product);
        if (empty($accessories)) {
            $accessories = $this->getAccessories($id_language, 0);
        }
        $resultAccessories = array();
        if (count($accessories) > 0) {
            foreach ($accessories as $value) {
                $objProduct = new Product($value['id_product'], true, $id_language);
                $tempGroups = $this->assignAttributesGroups($objProduct);
                $tempImages = $this->assignImages($objProduct);
                $value['groups'] = $tempGroups['groups'];
                $value['combinations'] = $tempGroups['combinations'];
                $value['colors'] = $tempGroups['colors'];
                $value['images'] = $tempImages['images'];
                $value['product'] = $objProduct;
                $value['display_qties'] = (int) Configuration::get('PS_DISPLAY_QTIES');
                $value['last_qties'] = (int) Configuration::get('PS_LAST_QTIES');
                $value['tax_enabled'] = Configuration::get('PS_TAX');
                $value['packItems'] = $value['id_product']->cache_is_pack ? Pack::getItemTable($value['id_product'], $id_language, true) : array();
                $ecotax_tax_amount = Tools::ps_round($objProduct->ecotax, 2);
                $ecotax_rate = (float) Tax::getProductEcotaxRate($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                if (Product::$_taxCalculationMethod == PS_TAX_INC && (int) Configuration::get('PS_TAX'))
                    $ecotax_tax_amount = Tools::ps_round($ecotax_tax_amount * (1 + $ecotax_rate / 100), 2);
                $value['ecotax_tax_inc'] = $ecotax_tax_amount;
                $value['ecotax_tax_exc'] = Tools::ps_round($objProduct->ecotax, 2);
                $id_group = (int) Group::getCurrent()->id;
                $group_reduction = GroupReduction::getValueForProduct($objProduct->id, $id_group);
                if ($group_reduction == 0)
                    $group_reduction = Group::getReduction((int) $this->context->cookie->id_customer) / 100;
                $value['group_reduction'] = (1 - $group_reduction);
                $value['ecotaxTax_rate'] = $ecotax_rate;
                $address = new Address($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                $value['no_tax'] = Tax::excludeTaxeOption() || !$objProduct->getTaxesRate($address);
                $resultAccessories[] = $value;
            }
        }
        $url = $smarty->tpl_vars['base_dir']->value;
        if (Configuration::get('PS_SSL_ENABLED') == 1) {
            $url_base = str_replace("http://", "https://", $url);
        } else {
            $url_base = $url;
        }
        $this->smarty->assign(array(
            'accessories' => $resultAccessories,
            'url_base' => $url_base,
            'id_lang' => $id_language,
            'currencySign' => $this->context->currency->sign, 'currencyRate' => $this->context->currency->conversion_rate,
            'currencyFormat' => $this->context->currency->format,
            'currencyBlank' => $this->context->currency->blank,
            'jqZoomEnabled' => Configuration::get('PS_DISPLAY_JQZOOM'),
            'ENT_NOQUOTES' => ENT_NOQUOTES,
            'outOfStockAllowed' => (int) Configuration::get('PS_ORDER_OUT_OF_STOCK'),
            'stock_management' => Configuration::get('PS_STOCK_MANAGEMENT'),
            'current_product_name' => ''
        ));
        return $this->display(__FILE__, 'popupaddtocart.tpl');
    }

    protected function assignAttributesGroups($objProduct) {
        $colors = array();
        $groups = array();
        $id_language = $this->context->language->id;
        // @todo (RM) should only get groups and not all declination ?
        $attributes_groups = $objProduct->getAttributesGroups($id_language);
        if (is_array($attributes_groups) && $attributes_groups) {
            $combination_images = $objProduct->getCombinationImages($id_language);
            $combination_prices_set = array();
            foreach ($attributes_groups as $k => $row) {
                // Color management
                if ((isset($row['attribute_color']) && $row['attribute_color']) || (file_exists(_PS_COL_IMG_DIR_ . $row['id_attribute'] . '.jpg'))) {
                    $colors[$row['id_attribute']]['value'] = $row['attribute_color'];
                    $colors[$row['id_attribute']]['name'] = $row['attribute_name'];
                    if (!isset($colors[$row['id_attribute']]['attributes_quantity']))
                        $colors[$row['id_attribute']]['attributes_quantity'] = 0;
                    $colors[$row['id_attribute']]['attributes_quantity'] += (int) $row['quantity'];
                }
                if (!isset($groups[$row['id_attribute_group']]))
                    $groups[$row['id_attribute_group']] = array(
                        'name' => $row['public_group_name'],
                        'group_type' => $row['group_type'],
                        'default' => -1,
                    );

                $groups[$row['id_attribute_group']]['attributes'][$row['id_attribute']] = $row['attribute_name'];
                if ($row['default_on'] && $groups[$row['id_attribute_group']]['default'] == -1)
                    $groups[$row['id_attribute_group']]['default'] = (int) $row['id_attribute'];
                if (!isset($groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']]))
                    $groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] = 0;
                $groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] += (int) $row['quantity'];


                $combinations[$row['id_product_attribute']]['attributes_values'][$row['id_attribute_group']] = $row['attribute_name'];
                $combinations[$row['id_product_attribute']]['attributes'][] = (int) $row['id_attribute'];
                $combinations[$row['id_product_attribute']]['price'] = (float) $row['price'];

                // Call getPriceStatic in order to set $combination_specific_price
                if (!isset($combination_prices_set[(int) $row['id_product_attribute']])) {
                    Product::getPriceStatic((int) $objProduct->id, false, $row['id_product_attribute'], 6, null, false, true, 1, false, null, null, null, $combination_specific_price);
                    $combination_prices_set[(int) $row['id_product_attribute']] = true;
                    $combinations[$row['id_product_attribute']]['specific_price'] = $combination_specific_price;
                }
                $combinations[$row['id_product_attribute']]['ecotax'] = (float) $row['ecotax'];
                $combinations[$row['id_product_attribute']]['weight'] = (float) $row['weight'];
                $combinations[$row['id_product_attribute']]['quantity'] = (int) $row['quantity'];
                $combinations[$row['id_product_attribute']]['reference'] = $row['reference'];
                $combinations[$row['id_product_attribute']]['unit_impact'] = $row['unit_price_impact'];
                $combinations[$row['id_product_attribute']]['minimal_quantity'] = $row['minimal_quantity'];
                if ($row['available_date'] != '0000-00-00')
                    $combinations[$row['id_product_attribute']]['available_date'] = $row['available_date'];
                else
                    $combinations[$row['id_product_attribute']]['available_date'] = '';

                if (!isset($combination_images[$row['id_product_attribute']][0]['id_image']))
                    $combinations[$row['id_product_attribute']]['id_image'] = -1;
                else {
                    $combinations[$row['id_product_attribute']]['id_image'] = $id_image = (int) $combination_images[$row['id_product_attribute']][0]['id_image'];
                    if ($row['default_on'] && $id_image > 0) {
                        if (isset($this->context->smarty->tpl_vars['images']->value))
                            $product_images = $this->context->smarty->tpl_vars['images']->value;
                        if (isset($product_images) && is_array($product_images) && isset($product_images[$id_image])) {
                            $product_images[$id_image]['cover'] = 1;
                        }
                        if (isset($this->context->smarty->tpl_vars['cover']->value))
                            $cover = $this->context->smarty->tpl_vars['cover']->value;
                        if (isset($cover) && is_array($cover) && isset($product_images) && is_array($product_images)) {
                            $product_images[$cover['id_image']]['cover'] = 0;
                            if (isset($product_images[$id_image]))
                                $cover = $product_images[$id_image];
                            $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objProduct->id . '-' . $id_image) : (int) $id_image);
                            $cover['id_image_only'] = (int) $id_image;
                        }
                    }
                }
            }

            if (!Product::isAvailableWhenOutOfStock($objProduct->out_of_stock) && Configuration::get('PS_DISP_UNAVAILABLE_ATTR') == 0) {
                foreach ($groups as &$group)
                    foreach ($group['attributes_quantity'] as $key => &$quantity)
                        if (!$quantity)
                            unset($group['attributes'][$key]);

                foreach ($colors as $key => $color)
                    if (!$color['attributes_quantity'])
                        unset($colors[$key]);
            }
            foreach ($combinations as $id_product_attribute => $comb) {
                $attribute_list = '';
                foreach ($comb['attributes'] as $id_attribute)
                    $attribute_list .= '\'' . (int) $id_attribute . '\',';
                $attribute_list = rtrim($attribute_list, ',');
                $combinations[$id_product_attribute]['list'] = $attribute_list;
            }
            $arrResult = array(
                'groups' => $groups,
                'combinations' => $combinations,
                'colors' => (count($colors)) ? $colors : false,
                    //'combinationImages' => $combination_images
            );
            return $arrResult;
        }
    }

    /**
     * Assign template vars related to images
     */
    protected function assignImages($objProduct) {
        $images = $objProduct->getImages((int) $this->context->cookie->id_lang);
        $product_images = array();

        foreach ($images as $k => $image) {
            if ($image['cover']) {
                $cover = $image;
                $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objProduct->id . '-' . $image['id_image']) : $image['id_image']);
                $cover['id_image_only'] = (int) $image['id_image'];
            }
            $product_images[(int) $image['id_image']] = $image;
        }
        $result = array(
            'images' => $product_images
        );
        return $result;
    }

    /**
     * Get product accessories
     *
     * @param integer $id_lang Language id
     * @return array Product accessories
     */
    public function getAccessories($id_lang, $id_product, $active = true, Context $context = null) {
        if (!$context)
            $context = Context::getContext();

        $sql = 'SELECT p.*, product_shop.*, IFNULL(stock.quantity, 0) as quantity, pl.`link_rewrite`,
					pl.`name`,
					MAX(image_shop.`id_image`) id_image, il.`legend`  FROM `' . _DB_PREFIX_ . 'accessory`
				LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = `id_product_2`
				' . Shop::addSqlAssociation('product', 'p') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (
					p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('pl') . '
				)
				LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (
					product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = ' . (int) $id_lang . Shop::addSqlRestrictionOnLang('cl') . '
				)
				LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product`)' .
                Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') . '
				LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . (int) $id_lang . ')
				LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON (p.`id_manufacturer`= m.`id_manufacturer`)
				' . Product::sqlStock('p', 0) . '
				WHERE ' .
                ($active ? ' product_shop.`active` = 1 AND product_shop.`visibility` != \'none\'' : '');
        if ($id_product > 0) {
            $sql.=' AND `id_product_1` = ' . $id_product;
            $sql.=' GROUP BY product_shop.id_product';
        } else {
            $nb = (int) (Configuration::get('DY_POPUPCART_NBR'));
            $sql.=' GROUP BY product_shop.id_product';
            $sql.=' ORDER BY RAND() LIMIT 0,' . ($nb ? $nb : self::DEF_COUNT);
        }

        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql))
            return false;
        return $result;
    }

    /**
     * Hien thi noi dung trong Admin
     * @return type
     */
    public function getContent() {
        $output = '<h2>' . $this->displayName . '</h2>';
        if (Tools::isSubmit('submitHomeFeatured')) {
            $nbr = abs((int) (Tools::getValue('nbr')));
            if (!$nbr or $nbr <= 0 or !Validate::isInt($nbr)) {
                $errors[] = $this->l('Invalid number of products');
            } else {
                Configuration::updateValue('DY_POPUPCART_NBR', (int) ($nbr));
            }

            if (isset($errors) and count($errors)) {
                $output .= $this->displayError(implode('<br />', $errors));
            } else {
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output . $this->displayForm();
    }

    /**
     * Hien thi Form trong Admin
     * @return string
     */
    public function displayForm() {
        $output = '
        <form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) .
                '" method="post">
            <fieldset><legend>' . $this->l('Settings') . '</legend>
                <label>' . $this->l('Number of products random accessories') . '</label>
                <div class="margin-form">
                    <input type="text" size="5" name="nbr" value="' . (int) (Configuration::get
                        ('DY_POPUPCART_NBR')) . '" />
                    <p class="clear">' . $this->l('Number of products random accessories (default: ' .
                        self::DEF_COUNT . ').') . '</p>

                </div>
                <center><input type="submit" name="submitHomeFeatured" value="' . $this->l('Save') .
                '" class="button" /></center>
            </fieldset>
        </form>';

        return $output;
    }

}
