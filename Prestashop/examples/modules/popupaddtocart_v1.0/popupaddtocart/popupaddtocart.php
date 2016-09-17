<?php

if (!defined('_PS_VERSION_'))
    exit;

class popupAddtocart extends Module {

    public function __construct() {
        $this->name = 'popupaddtocart';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'FGCTechlution';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
        $this->dependencies = array('blockcart');

        parent::__construct();

        $this->displayName = $this->l('Popup add to cart');
        $this->description = $this->l('Popup add to cart.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install() {
        $this->_clearCache('popupaddtocart.tpl');
        return (parent::install() && $this->registerHook('header') && $this->registerHook('addproduct') && $this->registerHook('updateproduct') && $this->registerHook('deleteproduct')
                );
    }

    public function uninstall() {
        $this->_clearCache('popupaddtocart.tpl');
        return parent::uninstall();
    }

    public function hookDisplayHeader() {
        $this->context->controller->addCSS($this->_path . 'css/popupaddtocart.css', 'all');
        $this->context->controller->addJS($this->_path . 'js/popupaddtocart.js', 'all');
        $this->context->controller->addJS($this->_path . 'js/pproduct.js', 'all');
        global $smarty;
        $this->smarty->assign(array(
            'url_base' => $smarty->tpl_vars['base_dir']->value,
            'id_lang' => $this->context->language->id
        ));
        return $this->display(__FILE__, 'definedjs.tpl');
    }

    public function hookAddProduct($params) {
        $this->_clearCache('popupaddtocart.tpl');
    }

    public function hookUpdateProduct($params) {
        $this->_clearCache('popupaddtocart.tpl');
    }

    public function hookDeleteProduct($params) {
        $this->_clearCache('popupaddtocart.tpl');
    }

    public function hookDisplayAdminProductsExtra($params) {
        $p = new Product($_REQUEST['id_product'], false, (int) Context::getContext()->language->id);
        $this->_clearCache('tab-body.tpl');
        $accessories = $p->getAccessories($this->context->language->id);
        $this->smarty->assign(array(
            'accessories' => $accessories
        ));
        return $this->display(__FILE__, 'tab-body.tpl');
    }

    /**
     * Ham su dung de hook vao cuoi 1 trang chi tiet cua 1 san pham. 
     * Chua dung
     * @global type $smarty
     * @param type $params
     * @return type
     */
    public function hookProductFooter($params) {
        global $smarty;
        $p = new Product($_REQUEST['id_product'], false, (int) Context::getContext()->language->id);
        $this->_clearCache('popupaddtocart.tpl');
        if (!$this->isCached('popupaddtocart.tpl', $this->getCacheId('popupaddtocart'))) {

            $accessories = $p->getAccessories($this->context->language->id);
            $resultAccessories = array();
            foreach ($accessories as $value) {
                $objProduct = new Product($value['id_product'], true, (int) Context::getContext()->language->id);
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
                $value['packItems'] = $value['id_product']->cache_is_pack ? Pack::getItemTable($value['id_product'], $this->context->language->id, true) : array();
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
            $this->smarty->assign(array(
                'accessories' => $resultAccessories,
                'url_base' => $smarty->tpl_vars['base_dir']->value,
                'id_lang' => $this->context->language->id,
                'currencySign' => $this->context->currency->sign, 'currencyRate' => $this->context->currency->conversion_rate,
                'currencyFormat' => $this->context->currency->format,
                'currencyBlank' => $this->context->currency->blank,
                'jqZoomEnabled' => Configuration::get('PS_DISPLAY_JQZOOM'),
                'ENT_NOQUOTES' => ENT_NOQUOTES,
                'outOfStockAllowed' => (int) Configuration::get('PS_ORDER_OUT_OF_STOCK'),
                'stock_management' => Configuration::get('PS_STOCK_MANAGEMENT'),
                'current_product_name' => $p->name
            ));
        }
        return $this->display(__FILE__, 'popupaddtocart.tpl', $this->getCacheId('popupaddtocart'));
    }

    /**
     * Ham phuc vu cho request Ajax
     * @global type $smarty
     * @param type $params
     * @return type
     */
    public function processDataForPopup($params) {
        global $smarty;
        $p = new Product($_REQUEST['id_product'], false, (int) Context::getContext()->language->id);
        $this->_clearCache('popupaddtocart.tpl');
        if (!$this->isCached('popupaddtocart.tpl', $this->getCacheId('popupaddtocart'))) {

            $accessories = $p->getAccessories($this->context->language->id);
            $resultAccessories = array();
            foreach ($accessories as $value) {
                $objProduct = new Product($value['id_product'], true, (int) Context::getContext()->language->id);
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
                $value['packItems'] = $value['id_product']->cache_is_pack ? Pack::getItemTable($value['id_product'], $this->context->language->id, true) : array();
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
            $this->smarty->assign(array(
                'accessories' => $resultAccessories,
                'url_base' => $smarty->tpl_vars['base_dir']->value,
                'id_lang' => $this->context->language->id,
                'currencySign' => $this->context->currency->sign, 'currencyRate' => $this->context->currency->conversion_rate,
                'currencyFormat' => $this->context->currency->format,
                'currencyBlank' => $this->context->currency->blank,
                'jqZoomEnabled' => Configuration::get('PS_DISPLAY_JQZOOM'),
                'ENT_NOQUOTES' => ENT_NOQUOTES,
                'outOfStockAllowed' => (int) Configuration::get('PS_ORDER_OUT_OF_STOCK'),
                'stock_management' => Configuration::get('PS_STOCK_MANAGEMENT'),
                'current_product_name' => $p->name
            ));
        }
        return $this->display(__FILE__, 'popupaddtocart.tpl', $this->getCacheId('popupaddtocart'));
    }

    protected function assignAttributesGroups($objProduct) {
        $colors = array();
        $groups = array();

        // @todo (RM) should only get groups and not all declination ?
        $attributes_groups = $objProduct->getAttributesGroups($this->context->language->id);
        if (is_array($attributes_groups) && $attributes_groups) {
            $combination_images = $objProduct->getCombinationImages($this->context->language->id);
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
                            $this->context->smarty->assign('mainImage', $product_images[$id_image]);
                            if (count($product_images))
                                $this->context->smarty->assign('images', $product_images);
                        }
                        if (isset($this->context->smarty->tpl_vars['cover']->value))
                            $cover = $this->context->smarty->tpl_vars['cover']->value;
                        if (isset($cover) && is_array($cover) && isset($product_images) && is_array($product_images)) {
                            $product_images[$cover['id_image']]['cover'] = 0;
                            if (isset($product_images[$id_image]))
                                $cover = $product_images[$id_image];
                            $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objProduct->id . '-' . $id_image) : (int) $id_image);
                            $cover['id_image_only'] = (int) $id_image;
                            $this->context->smarty->assign('cover', $cover);
                        }
                    }
                }
            }

            // wash attributes list (if some attributes are unavailables and if allowed to wash it)
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
                'combinationImages' => $combination_images);
            return $arrResult;
        }
    }

    /**
     * Assign template vars related to images
     */
    protected function assignImages($objProduct) {
        $images = $objProduct->getImages((int) $this->context->cookie->id_lang);
        $product_images = array();

        if (isset($images[0]))
            $this->context->smarty->assign('mainImage', $images[0]);
        foreach ($images as $k => $image) {
            if ($image['cover']) {
                $this->context->smarty->assign('mainImage', $image);
                $cover = $image;
                $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objProduct->id . '-' . $image['id_image']) : $image['id_image']);
                $cover['id_image_only'] = (int) $image['id_image'];
            }
            $product_images[(int) $image['id_image']] = $image;
        }

        if (!isset($cover)) {
            if (isset($images[0])) {
                $cover = $images[0];
                $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objProduct->id . '-' . $images[0]['id_image']) : $images[0]['id_image']);
                $cover['id_image_only'] = (int) $images[0]['id_image'];
            } else
                $cover = array(
                    'id_image' => $this->context->language->iso_code . '-default',
                    'legend' => 'No picture',
                    'title' => 'No picture'
                );
        }
        $size = Image::getSize(ImageType::getFormatedName('large'));
        $result = array(
            'have_image' => isset($cover['id_image']) ? array((int) $cover['id_image']) : Product::getCover((int) Tools::getValue('id_product')),
            'cover' => $cover,
            'imgWidth' => (int) $size['width'],
            'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
            'largeSize' => Image::getSize(ImageType::getFormatedName('large')),
            'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
            'col_img_dir' => _PS_COL_IMG_DIR_,
            'images' => $product_images
        );
        return $result;
    }

    /**
     * Ham phuc vu cho tim kiem san pham trong Admin
     * @param type $query
     * @param type $excludeIds
     * @param type $excludeVirtuals
     * @param type $exclude_packs
     * @return type
     */
    public function searchProducts($query, $excludeIds, $excludeVirtuals, $exclude_packs) {
        $sql = 'SELECT p.`id_product`, `reference`, pl.name
		FROM `' . _DB_PREFIX_ . 'product` p
		LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int) Context::getContext()->language->id . Shop::addSqlRestrictionOnLang('pl') . ')
		WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\')' .
                (!empty($excludeIds) ? ' AND p.id_product NOT IN (' . $excludeIds . ') ' : ' ') .
                ($excludeVirtuals ? 'AND p.id_product NOT IN (SELECT pd.id_product FROM `' . _DB_PREFIX_ . 'product_download` pd WHERE (pd.id_product = p.id_product))' : '') .
                ($exclude_packs ? 'AND (p.cache_is_pack IS NULL OR p.cache_is_pack = 0)' : '');

        $items = Db::getInstance()->executeS($sql);
        $arrResult = array();
        foreach ($items as $value) {
            $p = new Product($value['id_product'], false, (int) Context::getContext()->language->id);
            $images = $p->getImages((int) $this->context->cookie->id_lang);
            if (isset($images[0]))
                $main_image = $images[0];
            foreach ($images as $k => $image) {
                if ($image['cover']) {
                    $main_image = $image;
                    break;
                }
            }
            if ($main_image['id_image']) {
                $value['image'] = $main_image['id_image'];
            } else {
                $value['image'] = 0;
            }
            $arrResult[] = $value;
        }
        return $arrResult;
    }

    /**
     * Kiem tra 1 san pham co linh kien kem theo hay khong
     * @return boolean
     */
    public function checkAccessories() {
        $p = new Product($_REQUEST['id_product'], false, (int) Context::getContext()->language->id);
        $accessories = $p->getAccessories($this->context->language->id);
        if (count($accessories) > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>