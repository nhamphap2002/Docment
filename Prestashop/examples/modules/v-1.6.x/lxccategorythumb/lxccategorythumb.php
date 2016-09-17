<?php

if (!defined('_PS_VERSION_'))
    exit;

class Lxccategorythumb extends Module {

    public function __construct() {
        $this->name = 'lxccategorythumb';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Le Xuan Chien';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Category thumb module');
        $this->description = $this->l('Category thumb module.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install() {
        $this->_clearCache('*');
        if (!parent::install() || !$this->registerHook('displayTop'))
            return false;
        return true;
    }

    public function uninstall() {
        $this->_clearCache('*');
        if (!parent::uninstall() || !Configuration::deleteByName('lxccategorythumb'))
            return false;
        return true;
    }

    /**
     * 
     * @param type $params
     * @return type
     */
    public function hookDisplayTop() {
        if (!isset($this->context->controller->php_self) || $this->context->controller->php_self != 'index')
            return;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT c.*, cl.name, cl.description, cl.link_rewrite
			FROM `' . _DB_PREFIX_ . 'category` c
			INNER JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = ' . (int) $this->context->language->id . Shop::addSqlRestrictionOnLang('cl') . ')
			INNER JOIN `' . _DB_PREFIX_ . 'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = ' . (int) $this->context->shop->id . ')
			WHERE (c.`active` = 1 OR c.`id_category` = ' . (int) Configuration::get('PS_HOME_CATEGORY') . ')
			AND c.`id_category` != ' . (int) Configuration::get('PS_ROOT_CATEGORY') . '
			' . ((int) $maxdepth != 0 ? ' AND `level_depth` <= ' . (int) $maxdepth : '') . '
			' . $range . '
			AND c.id_category IN (
				SELECT id_category
				FROM `' . _DB_PREFIX_ . 'category_group`
				WHERE `id_group` IN (' . pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))) . ')
			)
			ORDER BY `level_depth` ASC, ' . (Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`') . ' ' . (Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));
        $cats = array();
        foreach ($result as $category) {

            if ((int) $category['level_depth'] == 2) {
                $obj = array();
                $obj['id_category'] = $category['id_category'];
                $obj['name'] = $category['name'];
                $cat = new Category($category['id_category']);
                $link = Tools::HtmlEntitiesUTF8($cat->getLink());
                $files = scandir(_PS_CAT_IMG_DIR_);
                $obj['link_thumb'] = '';
                if (count($files) > 0) {
                    $html .= '<li id="category-thumbnail">';

                    foreach ($files as $file)
                        if (preg_match('/' . $category['id_category'] . '-([0-9])?_thumb.jpg/i', $file) === 1)
                            $obj['link_thumb'] = $this->context->link->getMediaLink(_THEME_CAT_DIR_ . $file);
                }
                $obj['link'] = $link;
                $cats[] = $obj;
            }
        }
        $this->smarty->assign('cats', $cats);
        return $this->display(__FILE__, 'lxccategorythumb.tpl');
    }

}
