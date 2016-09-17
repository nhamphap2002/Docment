<?php

if (!defined('_PS_VERSION_'))
    exit;

class Lxcpopular extends Module {

    protected static $cache_products;

    public function __construct() {
        $this->name = 'lxcpopular';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Le Xuan Chien';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Popular module');
        $this->description = $this->l('Popular module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
        $this->_clearCache('*');
        if (!parent::install() || !$this->registerHook('displayPageSearch') || !$this->registerHook('displayPage404'))
            return false;
        return true;
    }

    public function uninstall() {
        $this->_clearCache('*');
        if (!parent::uninstall() || !Configuration::deleteByName('lxcpopular'))
            return false;
        return true;
    }

    public function _cacheProducts() {
        if (!isset(Lxcpopular::$cache_products)) {
            $category = new Category((int) Configuration::get('HOME_FEATURED_CAT'), (int) Context::getContext()->language->id);
            $nb = (int) Configuration::get('HOME_FEATURED_NBR');
            if (Configuration::get('HOME_FEATURED_RANDOMIZE'))
                Lxcpopular::$cache_products = $category->getProducts((int) Context::getContext()->language->id, 1, ($nb ? $nb : 8), null, null, false, true, true, ($nb ? $nb : 8));
            else
                Lxcpopular::$cache_products = $category->getProducts((int) Context::getContext()->language->id, 1, ($nb ? $nb : 8), 'position');
        }

        if (Lxcpopular::$cache_products === false || empty(Lxcpopular::$cache_products))
            return false;
    }

    /**
     * Cach goi hook trong template: {hook h='displayPageSearch' mod='lxcpopular'}
     * @param type $params
     * @return type
     */
    public function hookDisplayPageSearch($params) {
        $this->_cacheProducts();
        $this->smarty->assign(
                array(
                    'products' => Lxcpopular::$cache_products,
                    'add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
                    'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
                )
        );
        return $this->display(__FILE__, 'lxcpopular.tpl');
    }

    /**
     * Cach goi hook trong template: {hook h='displayPage404' mod='lxcpopular'}
     * @param type $params
     * @return type
     */
    public function hookDisplayPage404($params) {
        $this->_cacheProducts();
        $this->smarty->assign(
                array(
                    'products' => Lxcpopular::$cache_products,
                    'add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
                    'homeSize' => Image::getSize(ImageType::getFormatedName('home')),
                )
        );
        return $this->display(__FILE__, 'lxcpopular.tpl');
    }

}
