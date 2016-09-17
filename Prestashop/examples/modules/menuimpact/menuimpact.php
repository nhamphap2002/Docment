<?php

if (!defined('_PS_VERSION_'))
    exit;
if(!defined('link_rewrite')){
    define('link_rewrite', 1);
}

/*
  Changed by : Tran Trong Thang
  Email      : trantrongthang1207@gmail.com
 */
if (!class_exists('Mobile_Detect')) {
    require_once(dirname(__FILE__) . '/Mobile_Detect.php');
}

class menuimpact extends Module {

    private $_menuimp = '';
    private $_html = '';

    public function __construct() {
        $this->name = 'menuimpact';
        $this->tab = 'home';
        $this->version = '0.9';
        $this->author = 'GraphikS';
        $this->need_instance = 0;
        parent::__construct();
        $this->displayName = $this->l('Mega Menu Impact');
        $desc = $this->l('Menu for your homepage');
        $this->accord = intval(Configuration::get('PS_REWRITING_SETTINGS'));
    }

    public function install() {
        if (!parent::install() ||
                !$this->registerHook('top') || !$this->registerHook('header') || !$this->installDB())
            return false;
        return true;
    }

    public function installDb() {
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_setting` (`typeM` VARCHAR(6) NULL default "", `typeO` VARCHAR(6) NULL default "", `typeB` VARCHAR(6) NULL default "", `typeA` VARCHAR(6) NULL default "") ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet` (`id_onglet` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `id_shop` INT UNSIGNED NOT NULL,`posit_onglet` INT NOT NULL, `img_name` varchar(255) NULL, `img_link` LONGTEXT NULL, `bonfire` varchar(255) NULL, `big_bg_selection` VARCHAR(255) NULL,`custom_open` tinyint(1) unsigned NOT NULL DEFAULT \'0\') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet_lang` (`id_onglet` INT NOT NULL ,`id_lang` INT NOT NULL ,`id_shop` INT UNSIGNED NOT NULL,`name_onglet` VARCHAR( 128 ) NOT NULL , `blockTop` BLOB NULL ,`blockRight` BLOB NULL ,`blockLeft` BLOB NULL ,INDEX ( `id_onglet` ,`id_shop`, `id_lang` )) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet_langc` (`id_onglet` INT NOT NULL,`id_cat` INT NOT NULL ,`id_lang` INT NOT NULL ,`id_shop` INT UNSIGNED NOT NULL,`renommer` VARCHAR( 255 ) NOT NULL ,INDEX (`id_onglet`, `id_cat` , `id_lang` , `id_shop` )) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet_lkc` (`id_onglet` INT NOT NULL,`id_link_cat` INT NOT NULL, `pla_col` INT NOT NULL, `pla_lin` INT NOT NULL default 1, `accr_prod` VARCHAR( 6 ) NULL) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet_position` (`id_onglet` INT NOT NULL,`id_link_cat` INT NOT NULL, `niveau` INT NOT NULL default 1,`pla_lin` INT NOT NULL default 1) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');

        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_onglet_lien` (
`id_onglet` INT NOT NULL,
`newin` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
`link` VARCHAR(255) NOT NULL DEFAULT \'#\') ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');


        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_tunpip_menu` (`id_onglet` INT NOT NULL,`id_tunpip` INT UNSIGNED NOT NULL AUTO_INCREMENT, `id_parent` INT NOT NULL, `name_menu` VARCHAR( 255 ) NULL,`pla_col` INT NOT NULL, `pla_lin` INT NOT NULL, `link` LONGTEXT NULL,  PRIMARY KEY ( `id_onglet` , `id_tunpip` )) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'menimp_tunpip_menu_lang` (`id_onglet` INT NOT NULL,`id_tunpip` INT NOT NULL, `id_lang` INT NOT NULL, `name_menu` VARCHAR( 255 ) NULL,  PRIMARY KEY ( `id_onglet` , `id_tunpip`, `id_lang` )) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $id_shop = (int) $this->context->shop->id;
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet (`id_onglet`,`id_shop`, `posit_onglet`) VALUES (1,' . $id_shop . ', 99);');


        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lang (`id_onglet`, `id_lang`, `id_shop`, `name_onglet`) VALUES (1, 1,' . $id_shop . ', "Sample");');
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lien (`id_onglet`,`newin`, `link`) VALUES (1,0,"#");');
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lang (`id_onglet`, `id_lang`, `id_shop`, `name_onglet`) VALUES (1, 2,' . $id_shop . ', "Sample");');
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lang (`id_onglet`, `id_lang`, `id_shop`, `name_onglet`) VALUES (1, 3,' . $id_shop . ', "Sample");');
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lang (`id_onglet`, `id_lang`, `id_shop`, `name_onglet`) VALUES (1, 4,' . $id_shop . ', "Sample");');
        Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ . 'menimp_onglet_lang (`id_onglet`, `id_lang`, `id_shop`, `name_onglet`) VALUES (1, 5,' . $id_shop . ', "Sample");');
        return true;
    }

    public function uninstall() {
        if (!parent::uninstall() || !$this->uninstallDB())
            return false;return true;
    }

    private function uninstallDb() {
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet_position`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet_lang`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet_langc`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet_lkc`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_onglet_lien`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_setting`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_tunpip_menu`');
        Db::getInstance()->execute('DROP TABLE `' . _DB_PREFIX_ . 'menimp_tunpip_menu_lang`');
        return true;
    }

    public function getContent() {
        global $cookie, $OngletIdInEdit;
        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages();
        $iso = Language::getIsoById($defaultLanguage);
        $htmlOut = "";
        $errors = array();
        $erreurD = 0;
        if (Tools::isSubmit('EnregOnglet')) {
            $id_shop = (int) $this->context->shop->id;
            $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array('posit_onglet' => 99,), 'INSERT');
            $IdOnglet = Db::getInstance()->Insert_ID();
            if (!$result)
                $erreurD++;$languages = Language::getLanguages();
            $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lien', array('id_onglet' => $IdOnglet), 'INSERT');
            foreach ($languages as $language) {
                if (Tools::getValue('OngletName_' . $language['id_lang']) != '') {
                    $id_shop = (int) $this->context->shop->id;
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lang', array('id_onglet' => $IdOnglet, 'id_lang' => $language['id_lang'], 'id_shop' => $id_shop, 'name_onglet' => addslashes(Tools::getValue('OngletName_' . $language['id_lang']))), 'INSERT');
                    if (!$result)
                        $erreurD++;
                }
            }if ($erreurD != 0)
                $htmlOut .= $this->displayError($this->l('Error'));
            
                else$htmlOut .= $this->displayConfirmation($this->l('Ok'));
        }
        if (Tools::isSubmit('EnregOngleSett')) {

            Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lkc', "id_onglet = " . Tools::getValue('ButttonIdToUpdate'));
            Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_position', "id_onglet = " . Tools::getValue('ButttonIdToUpdate'));
            Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_langc', "id_onglet = " . Tools::getValue('ButttonIdToUpdate'));
            if (is_array(Tools::getValue('categoryBox'))) {
                foreach (Tools::getValue('categoryBox') as $id_cat => $cat) {
                    $nLineCat = Tools::getValue('lineBox_' . $cat);
                    $nColuC = Tools::getValue('columnBox_' . $cat);
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lkc', array('id_onglet' => Tools::getValue('ButttonIdToUpdate'), 'id_link_cat' => $cat, 'pla_lin' => $nLineCat, 'pla_col' => $nColuC, 'accr_prod' => Tools::getValue('viewProducts_' . $cat)), 'INSERT');
                } foreach ($_POST as $kPost => $vPost) {
                    if (substr($kPost, 0, 7) == "lineBox") {
                        $liDatas = explode('_', $kPost);
                        $idCat = $liDatas[1];
                        $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_position', array('id_onglet' => Tools::getValue('ButttonIdToUpdate'), 'id_link_cat' => $idCat, 'niveau' => Tools::getValue('State_' . $idCat), 'pla_lin' => $vPost), 'INSERT');
                        foreach ($languages as $language) {
                            if (Tools::getValue('textSubstitute_' . $idCat . "_" . $language['id_lang']) != '') {
                                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_langc', array('id_onglet' => Tools::getValue('ButttonIdToUpdate'), 'id_cat' => $idCat, 'id_lang' => $language['id_lang'], 'renommer' => addslashes(Tools::getValue('textSubstitute_' . $idCat . "_" . $language['id_lang']))), 'INSERT');
                            }
                        }
                    }
                } if (!$result)
                    $erreurD++;
            }Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lien', "id_onglet = " . Tools::getValue('ButttonIdToUpdate'));
            $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lien', array('id_onglet' => Tools::getValue('ButttonIdToUpdate'), 'link' => Tools::getValue('LinkPage'), 'newin' => Tools::getValue('newin')), 'INSERT');
            $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array('custom_open' => Tools::getValue('custom_open')), "UPDATE", "id_onglet=" . addslashes(Tools::getValue('ButttonIdToUpdate')));

            if (!$result)
                $erreurD++;$languages = Language::getLanguages();
            $bRightProg = $this->getOngletDetail(Tools::getValue('ButttonIdToUpdate'));
            if (sizeof($bRightProg)) {
                foreach ($bRightProg as $kSub => $ContSub) {
                    $infoSub[$ContSub['id_lang']]['blockRight'] = html_entity_decode($ContSub['blockRight']);
                    $infoSub[$ContSub['id_lang']]['blockLeft'] = html_entity_decode($ContSub['blockLeft']);
                    $infoSub[$ContSub['id_lang']]['blockTop'] = html_entity_decode($ContSub['blockTop']);
                }
            }Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lang', "id_onglet = " . Tools::getValue('ButttonIdToUpdate'));
            foreach ($languages as $language) {
                if (Tools::getValue('OngletNameEdit_' . $language['id_lang']) != '') {
                    $id_shop = (int) $this->context->shop->id;
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lang', array('id_onglet' => Tools::getValue('ButttonIdToUpdate'), 'id_lang' => $language['id_lang'], 'id_shop' => $id_shop, 'name_onglet' => addslashes(Tools::getValue('OngletNameEdit_' . $language['id_lang'])), 'blockRight' => htmlentities(addslashes($infoSub[$language['id_lang']]['blockRight'])), 'blockLeft' => htmlentities(addslashes($infoSub[$language['id_lang']]['blockLeft'])), 'blockTop' => htmlentities(addslashes($infoSub[$language['id_lang']]['blockTop']))), 'INSERT');
                    if (!$result)
                        $erreurD++;
                }
            }if (!$result)
                $erreurD++;if ($erreurD != 0)
                $htmlOut .= $this->displayError($this->l('Error'));
            
                else$htmlOut .= $this->displayConfirmation($this->l('Ok'));$OngletIdInEdit = Tools::getValue('ButttonIdToUpdate');
        }if (Tools::isSubmit('EnregOngletPos')) {
            if (trim(Tools::getValue('Organisation')) != '') {
                $OngletOrganisation = explode(',', Tools::getValue('Organisation'));
                $position = 1;
                foreach ($OngletOrganisation as $KPos => $VPos) {
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("posit_onglet" => $position), "UPDATE", "id_onglet =" . str_replace("onglet_", "", $VPos));
                    $position++;
                    if (!$result)
                        $erreurD++;
                }
            }if ($erreurD != 0)
                $htmlOut .= $this->displayError($this->l('Error'));
            
                else$htmlOut .= $this->displayConfirmation($this->l('Ok'));
        }if (Tools::isSubmit('EnregOngletMod')) {
            $erreurD = 0;
            $result = Db::getInstance()->autoExecuteWithNullValues(_DB_PREFIX_ . 'menimp_setting', $liDesign, "UPDATE");
            $ExtenAd = array(0 => ".jpg", 1 => ".gif", 2 => ".png");
            if ($erreurD != 0)
                $htmlOut .= $this->displayError($this->l('Error'));
            
                else$htmlOut .= $this->displayConfirmation($this->l('Ok'));
        }if (isset($_POST['Action']) && $_POST['Action'] != "") {
            switch ($_POST['Action']) {
                case "EditOnglet":$OngletIdInEdit = $_POST['OngletIdAction'];
                    break;
                case "DeleteOnglet":Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet', "id_onglet = " . $_POST['OngletIdAction']);
                    Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lang', "id_onglet = " . $_POST['OngletIdAction']);
                    Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lien', "id_onglet = " . $_POST['OngletIdAction']);
                    Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_onglet_lkc', "id_onglet = " . $_POST['OngletIdAction']);
                    Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_tunpip_menu', "id_onglet = " . $_POST['OngletIdAction']);
                    Db::getInstance()->delete(_DB_PREFIX_ . 'menimp_tunpip_menu_lang', "id_onglet = " . $_POST['OngletIdAction']);
                    break;
            }
        }if (isset($_POST['ActionFile']) && $_POST['ActionFile'] != "") {
            switch ($_POST['ActionFile']) {
                case "DeleteFile":$FichAsupprim = $_POST['FichAsupprim'];
                    if (is_file(dirname(__FILE__) . '/img/' . $FichAsupprim))
                        if (unlink(dirname(__FILE__) . '/img/' . $FichAsupprim))
                            $htmlOut .= $this->displayConfirmation($this->l('Deleted'));
                        
                            else$htmlOut .= $this->displayError($this->l('Error'));break;
            }
        }if (isset($_POST['ActionPicture']) && $_POST['ActionPicture'] != "") {
            switch ($_POST['ActionPicture']) {
                case "UploadPicture":$ExtenAd = array(0 => ".gif", 1 => ".jpg", 2 => ".png");
                    $extension = strtolower(substr($_FILES['PictureFile']['name'], -4));
                    $idOnglet = $_POST['idOnglet'];
                    if (in_array($extension, $ExtenAd)) {
                        if (isset($_FILES['PictureFile']['name'])) {
                            $img = dirname(__FILE__) . '/images/imgMenu' . $idOnglet . $extension;
                            if (move_uploaded_file($_FILES['PictureFile']['tmp_name'], $img)) {
                                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("img_name" => 'imgMenu' . $idOnglet . $extension, "img_link" => urlencode($_POST['imgLink'])), "UPDATE", "id_onglet=" . $idOnglet);
                                $htmlOut .= $this->displayConfirmation($this->l('OK'));
                            } 
                                else$htmlOut .= $this->displayError($this->l('Error'));
                        }
                    }if (isset($_POST['imgLink'])) {
                        $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("img_link" => urlencode($_POST['imgLink'])), "UPDATE", "id_onglet=" . $idOnglet);
                    }$OngletIdInEdit = $idOnglet;
                    break;
                case "DeletePicture":$idOnglet = $_POST['idOnglet'];
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("img_name" => ''), "UPDATE", "id_onglet=" . $idOnglet);
                    if (is_file(dirname(__FILE__) . '/images/' . $_POST['NamePicture']))
                        if (unlink(dirname(__FILE__) . '/images/' . $_POST['NamePicture']))
                            $htmlOut .= $this->displayConfirmation($this->l('Deleted'));
                        
                            else$htmlOut .= $this->displayError($this->l('Error'));$OngletIdInEdit = $idOnglet;
                    break;
            }foreach ($languages as $language) {
                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lang', array('blockLeft' => htmlentities(addslashes(Tools::getValue('blockLeft_' . $language['id_lang'])))), 'UPDATE', 'id_onglet=' . $_POST['idOnglet'] . ' AND id_lang=' . $language['id_lang']);
                if (!$result)
                    $erreurD++;
            }$OngletIdInEdit = $_POST['idOnglet'];
        }if (isset($_POST['ActionPictureBackground']) && $_POST['ActionPictureBackground'] != "") {
            switch ($_POST['ActionPictureBackground']) {
                case "UploadPictureBackground":$ExtenAd = array(0 => ".gif", 1 => ".jpg", 2 => ".png");
                    $extension = strtolower(substr($_FILES['PictureFileBackground']['name'], -4));
                    $idOnglet = $_POST['idOnglet'];
                    if (in_array($extension, $ExtenAd)) {
                        if (isset($_FILES['PictureFileBackground']['name'])) {
                            $img = dirname(__FILE__) . '/images_menu/imgBackground' . $idOnglet . $extension;
                            if (move_uploaded_file($_FILES['PictureFileBackground']['tmp_name'], $img)) {
                                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("big_bg_selection" => 'imgBackground' . $idOnglet . $extension), "UPDATE", "id_onglet=" . $idOnglet);
                                $htmlOut .= $this->displayConfirmation($this->l('OK'));
                            } 
                                else$htmlOut .= $this->displayError($this->l('Error'));
                        }
                    }$OngletIdInEdit = $idOnglet;
                    break;
                case "DeletePicture":$idOnglet = $_POST['idOnglet'];
                    $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet', array("big_bg_selection" => ''), "UPDATE", "id_onglet=" . $idOnglet);
                    if (is_file(dirname(__FILE__) . '/images_menu/' . $_POST['NamePictureBackground']))
                        if (unlink(dirname(__FILE__) . '/images_menu/' . $_POST['NamePictureBackground']))
                            $htmlOut .= $this->displayConfirmation($this->l('Deleted'));
                        
                            else$htmlOut .= $this->displayError($this->l('Error'));$OngletIdInEdit = $idOnglet;
                    break;
            }$OngletIdInEdit = $_POST['idOnglet'];
        }if (Tools::isSubmit('SubmitDetailSub')) {
            foreach ($languages as $language) {
                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lang', array('blockRight' => htmlentities(addslashes(Tools::getValue('blockRight_' . $language['id_lang'])))), 'UPDATE', 'id_onglet=' . Tools::getValue('idOnglet') . ' AND id_lang=' . $language['id_lang']);
                if (!$result)
                    $erreurD++;
            }$OngletIdInEdit = $_POST['idOnglet'];
        }if (Tools::isSubmit('SubmitDetailSubTr')) {
            foreach ($languages as $language) {
                $result = Db::getInstance()->autoExecute(_DB_PREFIX_ . 'menimp_onglet_lang', array('blockTop' => htmlentities(addslashes(Tools::getValue('blockRightTr_' . $language['id_lang'])))), 'UPDATE', 'id_onglet=' . Tools::getValue('idOnglet') . ' AND id_lang=' . $language['id_lang']);
                if (!$result)
                    $errorsNb++;
            }$OngletIdInEdit = Tools::getValue('idOnglet');
        }return $htmlOut . $this->displayForm();
    }

    static public function getOngletDetail($IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet tb LEFT JOIN ' . _DB_PREFIX_ . 'menimp_onglet_lang tbl ON (tb.id_onglet=tbl.id_onglet) WHERE tb.id_onglet=' . $IdOnglet . ' ORDER BY posit_onglet ASC, name_onglet ASC');
    }

    static public function getOngletLinksCat($IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet_lkc WHERE id_onglet=' . $IdOnglet . ' ORDER BY pla_lin ASC, pla_col ASC, id_link_cat ASC ');
    }

    static public function getOngletLinksCustom($IdOnglet, $idLang) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_tunpip_menu tb INNER JOIN ' . _DB_PREFIX_ . 'menimp_tunpip_menu_lang tbl ON (tb.id_onglet=tbl.id_onglet AND tb.id_tunpip=tbl.id_tunpip) WHERE tb.id_onglet=' . $IdOnglet . ' AND tb.id_parent = 0 AND tbl.id_lang=' . $idLang . ' ORDER BY tb.pla_lin ASC, tb.pla_col ASC ');
    }

    static public function getOngletLinks($IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet_lien WHERE id_onglet=' . $IdOnglet . '');
    }

    static public function getOngletOrganization($IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet_position WHERE id_onglet=' . $IdOnglet . '');
    }

    static public function getNameCategory($IdCat, $IdLang, $IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'category_lang tb INNER JOIN ' . _DB_PREFIX_ . 'menimp_onglet_position tbl ON (tb.id_category=tbl.id_link_cat) WHERE tb.id_category=' . $IdCat . ' AND tb.id_lang=' . $IdLang . ' and tbl.id_onglet=' . $IdOnglet . ' ');
    }

    static public function getNameSubstitute($IdCat, $IdLang, $IdOnglet) {
        $return[0]['renommer'] = "";
        $result = Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet_langc WHERE id_cat=' . $IdCat . ' AND id_lang=' . $IdLang . ' and id_onglet=' . $IdOnglet . ' ');
        if ($result)
            return $result;return $return;
    }

    static public function getAllNameSubstitute($IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_onglet_langc WHERE  id_onglet=' . $IdOnglet . ' ');
    }

    static public function getNameCategoryUnder($IdCat, $IdOnglet) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'category tb INNER JOIN ' . _DB_PREFIX_ . 'menimp_onglet_position tbl ON (tb.id_category=tbl.id_link_cat)WHERE tb.id_parent=' . $IdCat . ' and tbl.niveau=1 and tb.active=1 and tbl.id_onglet=' . $IdOnglet . ' ORDER BY tbl.pla_lin ASC ');
    }

    static public function getProductsUnder($IdCat, $IdLang) {
        return Db::getInstance()->ExecuteS('SELECT *FROM (' . _DB_PREFIX_ . 'category_product tb INNER JOIN ' . _DB_PREFIX_ . 'product_lang tbl ON (tb.id_product=tbl.id_product)) INNER JOIN ' . _DB_PREFIX_ . 'product tbll on (tb.id_product=tbll.id_product) WHERE tb.id_category=' . $IdCat . ' and tbll.active=1 and tbl.id_lang=' . $IdLang . ' ORDER BY tbl.name ASC ');
    }

    static public function getOngletLinksCustomUnder($IdOnglet, $IdParent, $idLang) {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_tunpip_menu tb INNER JOIN ' . _DB_PREFIX_ . 'menimp_tunpip_menu_lang tbl ON (tb.id_onglet=tbl.id_onglet AND tb.id_tunpip=tbl.id_tunpip) WHERE tb.id_onglet=' . $IdOnglet . ' AND tb.id_parent = ' . $IdParent . ' AND tbl.id_lang = ' . $idLang . ' ORDER BY tb.pla_lin ASC');
    }

    static public function getParameters() {
        return Db::getInstance()->ExecuteS('SELECT *FROM ' . _DB_PREFIX_ . 'menimp_setting LIMIT 1');
    }

    static public function getMaximumColumns($IdOnglet) {
        $maximumCols = 0;
        $result = Db::getInstance()->ExecuteS('SELECT pla_lin, count(id_link_cat) as nbCat  FROM ' . _DB_PREFIX_ . 'menimp_onglet_lkc WHERE id_onglet=' . $IdOnglet . ' GROUP BY pla_lin  ');
        if (sizeof($result)) {
            foreach ($result as $kr => $ContResult)
                if ($maximumCols < $ContResult['nbCat'])
                    $maximumCols = $ContResult['nbCat'];
        }return $maximumCols;
    }

    static public function getNbColumns($IdOnglet, $Line) {
        return Db::getInstance()->ExecuteS('SELECT count(id_link_cat) as nbCols FROM ' . _DB_PREFIX_ . 'menimp_onglet_lkc WHERE id_onglet=' . $IdOnglet . ' AND pla_lin=' . $Line);
    }

    public function getCategoryLinkMD($id_category, $alias = NULL) {
        if (is_object($id_category))
            return ($this->accord == 1) ? (_PS_BASE_URL_ . __PS_BASE_URI__ . intval($id_category->id) . '-' . $id_category->catalog / link_rewrite) : (_PS_BASE_URL_ . __PS_BASE_URI__ . 'category.php?id_category=' . intval($id_category->id));if ($alias)
            return ($this->accord == 1) ? (_PS_BASE_URL_ . __PS_BASE_URI__ . intval($id_category) . '-' . $alias) : (_PS_BASE_URL_ . __PS_BASE_URI__ . 'category.php?id_category=' . intval($id_category));return _PS_BASE_URL_ . __PS_BASE_URI__ . 'category.php?id_category=' . intval($id_category);
    }

    function recurseCategoryD($indexedCategories, $categories, $current, $id_category = 1, $id_category_default = NULL, $CategoryName) {
        global $done, $cookie;
        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages();
        $iso = Language::getIsoById($defaultLanguage);

        static $sautdeligne;
        if (!is_array($CategorySelected))
            $CategorySelected = array();
        $id_obj = intval(Tools::getValue($this->identifier));
        if (!isset($done[$current['infos']['id_parent']]))
            $done[$current['infos']['id_parent']] = 0;
        $done[$current['infos']['id_parent']] += 1;

        $todo = sizeof($categories[$current['infos']['id_parent']]);
        $doneC = $done[$current['infos']['id_parent']];
        $niveau = $current['infos']['level_depth'] + 1;
        $img = $niveau == 1 ? 'n1.png' : 'n' . $niveau . '_' . ($todo == $doneC ? 'f' : 'b') . '.png';

        $this->_html .= '

<li class="' . $id_category . '">' . stripslashes($current['infos']['name']) . '
<input id="numerotation_' . $id_category . '" type="text" value="' . $id_category . '">
        </li>';

        if (isset($categories[$id_category]))
            foreach ($categories[$id_category] AS $key => $row)
                if ($key != 'infos')
                    $this->recurseCategoryD($indexedCategories, $categories, $categories[$id_category][$key], $key, NULL, $CategorySelected, $CategoryLine, $CategoryColumn, $CategoryName, $CategoryState, $ViewProducts);
    }

    function recurseCategory($indexedCategories, $categories, $current, $id_category = 1, $id_category_default = NULL, $CategorySelected, $CategoryLine, $CategoryColumn, $CategoryName, $CategoryState, $ViewProducts) {
        global $done, $cookie;
        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages();
        $iso = Language::getIsoById($defaultLanguage);

        static $sautdeligne;
        if (!is_array($CategorySelected))
            $CategorySelected = array();
        $id_obj = intval(Tools::getValue($this->identifier));
        if (!isset($done[$current['infos']['id_parent']]))
            $done[$current['infos']['id_parent']] = 0;$done[$current['infos']['id_parent']] += 1;
        $todo = sizeof($categories[$current['infos']['id_parent']]);
        $doneC = $done[$current['infos']['id_parent']];
        $niveau = $current['infos']['level_depth'] + 1;
        $img = $niveau == 1 ? 'n1.png' : 'n' . $niveau . '_' . ($todo == $doneC ? 'f' : 'b') . '.png';
        if (!isset($CategoryLine[$id_category]))
            $CategoryLine[$id_category] = '';if (!isset($CategoryColumn[$id_category]))
            $CategoryColumn[$id_category] = '';if (!isset($CategoryState[$id_category]))
            $CategoryState[$id_category] = '';$this->_html .= '<tr class="' . ($sautdeligne++ % 2 ? 'sautdeligne' : 'moinsligne') . ' misenfor_' . $id_category . '"><td><input type="checkbox" name="categoryBox[]" class="categoryBox' . ($id_category_default != NULL ? ' id_category_default' : '') . '" id="categoryBox_' . $id_category . '" value="' . $id_category . '"' . (((in_array($id_category, $indexedCategories) OR (intval(Tools::getValue('id_category')) == $id_category AND !intval($id_obj))) OR in_array($id_category, $CategorySelected)) ? ' checked="checked"' : '') . ' ' . ($current['infos']['active'] == 0 ? " disabled" : false) . '/></td><td>' . $id_category . '</td><td valign="top"><img src="' . $this->_path . 'img/' . $img . '" alt="" /> &nbsp;<label id="categoryBox_' . $id_category . '" for="categoryBox_' . $id_category . '" class="t">' . stripslashes($current['infos']['name']) . '</label>';
        $this->_html .= '</td>';
        $this->_html .= '<td>';
        $this->_html .= '<table cellpadding="0" cellspacing="0" width="100%"><tr ><td class="pos1">' . $this->l('Positioning') . ' :</td><td class="pos1">' . $this->l('Colomun') . '&nbsp;<select id="columnBox_' . $id_category . '" name="columnBox_' . $id_category . '" style="font-size : 10px">';
        for ($c = 1; $c <= 4; $c++)
            $this->_html .= '<option class="column_' . $c . '" value="' . $c . '" ' . ($CategoryColumn[$id_category] == $c ? " selected" : false) . '>' . $c . '</option>';$this->_html .= '</select>&nbsp;&nbsp;&nbsp;' . $this->l('Line') . '&nbsp;<select name="lineBox_' . $id_category . '" style="font-size : 10px"><option value="1" ' . ($CategoryLine[$id_category] == 1 || $CategoryLine[$id_category] == "" ? " selected" : false) . '>1</option><option value="2" ' . ($CategoryLine[$id_category] == 2 ? " selected" : false) . '>2</option><option value="3" ' . ($CategoryLine[$id_category] == 3 ? " selected" : false) . '>3</option><option value="4" ' . ($CategoryLine[$id_category] == 4 ? " selected" : false) . '>4</option><option value="5" ' . ($CategoryLine[$id_category] == 5 ? " selected" : false) . '>5</option><option value="6" ' . ($CategoryLine[$id_category] == 6 ? " selected" : false) . '>6</option><option value="7" ' . ($CategoryLine[$id_category] == 7 ? " selected" : false) . '>7</option><option value="8" ' . ($CategoryLine[$id_category] == 8 ? " selected" : false) . '>8</option></select><select style="display:none;"  id="State_' . $id_category . '" name="State_' . $id_category . '" style="font-size : 10px"><option value="0" ' . ($CategoryState[$id_category] == 0 ? " selected" : false) . '>' . $this->l('disabled') . '</option><option value="1" ' . ($CategoryState[$id_category] == 1 || $CategoryState[$id_category] == "" ? " selected" : false) . '>' . $this->l('enabled') . '</option></select></td></tr><tr><td class="pos2">' . $this->l('Rename') . '&nbsp;:&nbsp;</td><td class="pos2">';
        foreach ($languages as $language) {
            if (!isset($CategoryName[$id_category][$language['id_lang']]))
                $CategoryName[$id_category][$language['id_lang']] = '';if (!isset($ViewProducts[$id_category]))
                $ViewProducts[$id_category] = ''; $this->_html .= '<div id="DivLang' . $id_category . '_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . '; float: left" class="divLang pos2">';
            $this->_html .= '<input type="text" id="textSubstitute_' . $id_category . '_' . $language['id_lang'] . '" name="textSubstitute_' . $id_category . '_' . $language['id_lang'] . '" value="' . $CategoryName[$id_category][$language['id_lang']] . '" size = "20" style="font-size : 10px"></div>';
        }$this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'DivLang' . $id_category, 'DivLang' . $id_category, true);
        $this->_html .= '<input  style="display:none;" class="check1" type="checkbox" id="viewProducts_' . $id_category . '" name="viewProducts_' . $id_category . '" ' . ($ViewProducts[$id_category] == 'on' ? " checked=\"checked\"" : false) . '>';

        $this->_html .= '</td></tr></table>';
        $this->_html.= '</td>';
        $this->_html .= '</tr>';
        if (isset($categories[$id_category]))
            foreach ($categories[$id_category] AS $key => $row)
                if ($key != 'infos')
                    $this->recurseCategory($indexedCategories, $categories, $categories[$id_category][$key], $key, NULL, $CategorySelected, $CategoryLine, $CategoryColumn, $CategoryName, $CategoryState, $ViewProducts);
    }

    public function displayFlagsMD($languages, $defaultLanguage, $ids, $id, $return = false) {
        if (sizeof($languages) == 1)
            return false;$defaultIso = Language::getIsoById($defaultLanguage);
        $htmlOut = '<div class="display_flags" style="float: left"><img src="../img/l/' . $defaultLanguage . '.jpg" class="pointer" id="language_current_' . $id . '" onclick="showLanguagesMD(\'' . $id . '\');" alt="" /></div><div id="languages_' . $id . '" class="language_flags">';
        foreach ($languages as $language)
            $htmlOut .= '<img src="../img/l/' . intval($language['id_lang']) . '.jpg" class="pointer" alt="' . $language['name'] . '" title="' . $language['name'] . '" onclick="changeLanguageMD(\'' . $id . '\', \'' . $ids . '\', ' . $language['id_lang'] . ', \'' . $language['iso_code'] . '\');" /> ';$htmlOut .= '</div>';
        if ($return)
            return $htmlOut;echo $htmlOut;
    }

    public function displayForm() {
        global $cookie, $OngletIdInEdit;
        $defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
        $languages = Language::getLanguages();
        $iso = Language::getIsoById($defaultLanguage);
        ($OngletIdInEdit != '' && $OngletIdInEdit != 0) ? $languageIds = 'OngletsEdit' . utf8_encode('ï¿½') . 'Onglets' : $languageIds = 'Onglets';
        $id_shop = (int) $this->context->shop->id;
        $liOngletsOrganizate = array();
        $SMsettings = array();
        $SMsettings = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'menimp_onglet tb LEFT JOIN ' . _DB_PREFIX_ . 'menimp_onglet_lang tbl 
ON (tb.id_onglet=tbl.id_onglet) 
WHERE tbl.id_lang=' . $cookie->id_lang . ' And tbl.id_shop=' . $id_shop . '  ORDER BY posit_onglet ASC, name_onglet ASC');
        $SettingsM = array();
        $SettingsM = $this->getParameters();
        $this->_html .='
<link rel="stylesheet" href="' . $this->_path . 'css/setting.css" type="text/css"/>
<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/jquery/jquery-ui.will.be.removed.in.1.6.js"></script>
';
        $this->_html .='
<script type="text/javascript">id_language = Number(' . $defaultLanguage . ');</script>
<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="' . __PS_BASE_URI__ . 'js/tinymce.inc.js"></script>
<script type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "advanced",
plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : false,
content_css : "' . __PS_BASE_URI__ . 'themes/' . _THEME_NAME_ . '/css/global.css",
document_base_url : "' . __PS_BASE_URI__ . '",
width: "390",
height: "auto",
template_external_list_url : "lists/template_list.js",
external_link_list_url : "lists/link_list.js",
external_image_list_url : "lists/image_list.js",
media_external_list_url : "lists/media_list.js",
elements : "nourlconvert",
convert_urls : false,
language : "' . (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en') . '"
});
function	showLanguagesMD(id)
{
getE("languages_" + id).style.display = "block";
}
function EditOnglet(OngletId) {
$("#Action").val("EditOnglet");
$("#OngletIdAction").val(OngletId);
$("#formnewonglet").submit();
}
function DeleteOnglet(OngletId) {
$("#Action").val("DeleteOnglet");
$("#OngletIdAction").val(OngletId);
$("#formnewonglet").submit();
}
function AfficheMasqueSlide(elt) {
($("#"+elt).css("display") == "none") ? $("#"+elt).slideDown("normal") : $("#"+elt).slideUp("normal");
}
function supprImages(imagesAsupprim) {
if(confirm("' . $this->l('Do you want to delete this file ?') . '")) {
$("#ActionFile").val("DeleteFile");
$("#FichAsupprim").val(imagesAsupprim);
$("#formdesign").submit();					
}
}
var wait = "<div widht=\'100%\' align=\'center\' style=\'height : 190px\'><BR><BR><BR><BR><img src=\'' . $this->_path . 'img/loading.png\'><BR>' . $this->l('Loading') . '</div>";
function displayDetailMenu() {
$.ajax({
method : "GET",
url: "' . $this->_path . 'ligen.php",
data: {
action: "DetailMenu",
idOnglet: $("#ButttonIdToUpdate").val(), 
idLang: ' . $cookie->id_lang . '
},
success: function(data) {
$("#tunpipMenu").html(data)
}
});	
}
function addCustomMenu(IdOnglet) {
if($("#CustomMenuName").val() != "") {
$("#tunpipMenu").html(wait)
$.ajax({
method : "GET",
url: "' . $this->_path . 'ligen.php",
data: {
action: "CustomMenuAdd",
idOnglet: $("#ButttonIdToUpdate").val(),';
        foreach ($languages as $language)
            $this->_html .= 'MenuName_' . $language['id_lang'] . ' : $("#CustomMenuName_' . $language['id_lang'] . '").val(),';
        $this->_html .= 'idLang: ' . $cookie->id_lang . '
},
success: function() {
displayDetailMenu()
}
});
}
else {
alert("' . $this->l('Please entre Menu name.') . '")
}
}
function deleteCustomMenu(OngletId, CustomMenuId) {
$("#tunpipMenu").html(wait)
$.ajax({
method : "GET",
url: "' . $this->_path . 'ligen.php",
data: {
action: "CustomMenuDelete",
idOnglet: OngletId, 
idCustomMenu: CustomMenuId, 
idLang: ' . $cookie->id_lang . '
},
success: function() {
displayDetailMenu()
}
});	
}
function saveCustomMenu(OngletId, CustomMenuId) {
';
        foreach ($languages as $language) {
            $this->_html .= 'NewNameMenu_' . $language['id_lang'] . ' = $("#MenuName_"+OngletId+"_"+CustomMenuId+"_' . $language['id_lang'] . '").val();
';
        }
        $this->_html .= '
NewMenuLink = $("#MenuLink_"+OngletId+"_"+CustomMenuId).val();
Newline		= $("#line_"+OngletId+"_"+CustomMenuId).val();
Newcolumn 	= $("#column_"+OngletId+"_"+CustomMenuId).val();
$("#tunpipMenu").html(wait)
$.ajax({
method : "GET",
url: "' . $this->_path . 'ligen.php",
data: {
action: "CustomMenuSave",
idOnglet: OngletId, 
idCustomMenu: CustomMenuId,
';
        foreach ($languages as $language)
            $this->_html .= 'nameMenu_' . $language['id_lang'] . ': NewNameMenu_' . $language['id_lang'] . ', 
';
        $this->_html .= 'linkMenu: NewMenuLink, 
lineMenu: Newline, 
columnMenu: Newcolumn, 
idLang: ' . $cookie->id_lang . '
},
success: function(data) {
displayDetailMenu()
}
});	
}
function addCustomSubMenu(OngletId, CustomMenuId) {
if($("#CustomSubMenuName" + CustomMenuId).val() != "") {
';
        foreach ($languages as $language)
            $this->_html .= 'NewSubMenu_' . $language['id_lang'] . ' = $("#CustomSubMenuName_" + CustomMenuId + "_' . $language['id_lang'] . '").val();
';
        $this->_html .= '$("#tunpipMenu").html(wait)
$.ajax({
method : "GET",
url: "' . $this->_path . 'ligen.php",
data: {
action: "CustomSubMenuAdd",
idOnglet: OngletId, 
idCustomMenu: CustomMenuId,
';
        foreach ($languages as $language)
            $this->_html .= 'SubMenuName_' . $language['id_lang'] . ' : NewSubMenu_' . $language['id_lang'] . ', 
';
        $this->_html .= 'idLang: ' . $cookie->id_lang . '
},
success: function() {
displayDetailMenu()
}
});
}
else {
alert("' . $this->l('Please entre Sub-Menu name.') . '")
}
}
function changeLanguageMD(field, fieldsString, id_language_new, iso_code)
{
var fields = $(".divLang");
for (var i = 0; i < fields.length; ++i)
{
eltId = fields[i].id;
eltTab = eltId.split("_");
(eltTab[1] != id_language_new) ? getE(eltId).style.display = "none" : getE(eltId).style.display = "block";
getE("language_current_" + eltTab[0]).src = "../img/l/" + id_language_new + ".jpg";
}
getE("languages_" + field).style.display = "none";
id_language = id_language_new;
}
function supprImagesMenu() {
$("#ActionPicture").val("DeletePicture")
$("#form_upload_picture").submit();
}
</script>';

        if (!is_writable(dirname(__FILE__) . '/img/'))
            $this->_html .= $this->displayError($this->l('Folder "img" is not writable'));$this->_html .= '<H2>' . $this->displayName . '</H2>';
        $this->_html .= '<fieldset id="setting_sp"><h2 class="titler">' . $this->l('Create a new Link') . '</h2>';
        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" name="formnewonglet" id="formnewonglet">';
        $this->_html .= '<label id="lb1">' . $this->l('Link Name') . ' : </label>';
        foreach ($languages as $language) {
            $this->_html .= '<div id="Onglets_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;" class="divLang"><input size="40" type="text" id="OngletName_' . $language['id_lang'] . '" name="OngletName_' . $language['id_lang'] . '"></div>';
        }$this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'Onglets', 'Onglets', true);
        $this->_html .= '<p align="center"><input name="EnregOnglet" type="submit" value="' . $this->l('Create') . '" class="button save1" ></p>';
        $this->_html .= '<input type="hidden" id="OngletIdAction" name="OngletIdAction" value="">';
        $this->_html .= '<input type="hidden" id="Action" name="Action" value="">';
        $this->_html .= '</form>';
        $this->_html .= '</fieldset><BR>';
        $this->_html .= '<fieldset id="setting_sp"><p class="titler">' . $this->l('Configuration and Position') . '';
        $this->_html .= '</p>';
        $this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" name="formorganizeonglet" id="formorganizeonglet"><BR>';
        $this->_html .= '<div class="mise_en_forme"><ul id="sortable">';
        if (sizeof($SMsettings)) {
            foreach ($SMsettings as $kMDConf => $ContMDConf) {
                $this->_html .= '<li style="float:left" class="Ongletlistitem" id="onglet_' . $ContMDConf['id_onglet'] . '">';
                $this->_html .= '' . $ContMDConf['name_onglet'] . '';
                $this->_html .= '<img class="edito" src="../img/admin/edit.gif" title="' . $this->l('Edit') . '" onclick="EditOnglet(\'' . $ContMDConf['id_onglet'] . '\')" style="cursor:pointer">';
                $this->_html .= '<img src="../img/admin/disabled.gif" title="' . $this->l('Delete') . '" onclick="DeleteOnglet(\'' . $ContMDConf['id_onglet'] . '\')" style="cursor:pointer">';
                $this->_html .= '</li>';
                $liOngletsOrganizate[] = "onglet_" . $ContMDConf['id_onglet'];
            }
        }$this->_html .= '</ul></div><BR><BR><BR><BR>';
        $this->_html .= '<p align="center" style="display:none;"><input name="EnregOngletPos" type="submit" value="' . $this->l('Update the position') . '" class="button position_bt"></p>';
        $this->_html .= '<input type="hidden" id="Organisation" name="Organisation" value="' . implode(',', $liOngletsOrganizate) . '">';
        $this->_html .= '<input type="hidden" value="' . $OngletIdInEdit . '" id="ButttonIdToUpdateOrganization" name="ButttonIdToUpdateOrganization">';
        $this->_html .= '</form>';
        $this->_html .= '</fieldset><BR>';
        $this->_html .= '
<script>
$(function() {
$("#sortable").sortable({ opacity: 0.6, scroll: true ,position:"left", revert: true , cursor: "move", update: function() {
$("#Organisation").val($(this).sortable("toArray"))
$(".position_bt").click();
}});
jQuery("#lignh .presentation_bar").click(function(){
if (jQuery("#lignh .presentation_cont").hasClass("ouverture")){
        $("#lignh .presentation_cont").hide("slow").removeClass("ouverture");
}else {
        $("#lignh .presentation_cont").show("slow").addClass("ouverture");
     }
return false;
});
jQuery("#lignh2 .presentation_bar").click(function(){
if (jQuery("#lignh2 .presentation_cont").hasClass("ouverture")){
        $("#lignh2 .presentation_cont").hide("slow").removeClass("ouverture");
}else {
        $("#lignh2 .presentation_cont").show("slow").addClass("ouverture");
     }
return false;
});
jQuery("#lignh3 .presentation_bar").click(function(){
if (jQuery("#lignh3 .presentation_cont").hasClass("ouverture")){
        $("#lignh3 .presentation_cont").hide("slow").removeClass("ouverture");
}else {
        $("#lignh3 .presentation_cont").show("slow").addClass("ouverture");
     }
return false;
});
jQuery("#lignh4 .presentation_bar").click(function(){
if (jQuery("#lignh4 .presentation_cont").hasClass("ouverture")){
        $("#lignh4 .presentation_cont").hide("slow").removeClass("ouverture");
}else {
        $("#lignh4 .presentation_cont").show("slow").addClass("ouverture");
     }
return false;
});

});
</script>';
        if ($OngletIdInEdit != '' && $OngletIdInEdit != 0) {
            $OngletDetail = array();
            $OngletLinksCat = array();
            $OngletLinks = array();
            $liCategoryTextState = array();
            $liCategoryTextSubstitute = array();
            $liCategoryColumn = array();
            $liCategoryLine = array();
            $liCategorySelected = array();
            $liCategoryViewProducts = array();
            $OngletDetail = $this->getOngletDetail($OngletIdInEdit);
            $OngletLinksCat = $this->getOngletLinksCat($OngletIdInEdit);
            $OngletLinks = $this->getOngletLinks($OngletIdInEdit);
            $OngletOrganization = $this->getOngletOrganization($OngletIdInEdit);
            $OngletNameSubstitute = $this->getAllNameSubstitute($OngletIdInEdit);
            if (sizeof($OngletDetail)) {
                foreach ($OngletDetail as $kDetail => $ContDetail) {
                    $liNameLang[$ContDetail['id_lang']] = $ContDetail['name_onglet'];
                    $liDetailSubLang[$ContDetail['id_lang']] = $ContDetail['blockRight'];
                    $liDetailSubLeftLang[$ContDetail['id_lang']] = $ContDetail['blockLeft'];
                    $liDetailSubTrLang[$ContDetail['id_lang']] = $ContDetail['blockTop'];
                }
            }
            if (sizeof($OngletLinksCat) && is_array($OngletLinksCat))
                foreach ($OngletLinksCat as $k) {
                    $liCategorySelected[$k['id_link_cat']] = $k['id_link_cat'];
                    $liCategoryColumn[$k['id_link_cat']] = $k['pla_col'];
                    $liCategoryViewProducts[$k['id_link_cat']] = $k['accr_prod'];
                }
            if (sizeof($OngletOrganization) && is_array($OngletOrganization))
                foreach ($OngletOrganization as $k) {
                    $liCategoryLine[$k['id_link_cat']] = $k['pla_lin'];
                    $liCategoryTextState[$k['id_link_cat']] = $k['niveau'];
                }
            if (sizeof($OngletNameSubstitute) && is_array($OngletNameSubstitute))
                foreach ($OngletNameSubstitute as $k) {
                    $liCategoryTextSubstitute[$k['id_cat']][$k['id_lang']] = $k['renommer'];
                }
            $this->_html .= '<fieldset id="setting_sp">
<p class="titler">' . $this->l('SubMenu Setting') . '';
            $this->_html .= '</p><BR>';
            $this->_html .= '
<div id="lignh4">
<div class="presentation_bar">
<p>' . $this->l('Setting Center Block') . '</p>
</div>
<div class="presentation_cont">';
            $this->_html .='<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" name="formongletparameters" id="formongletparameters">';
            $this->_html .= '
<p class="sector_1">
<label>' . $this->l('Rename Main Link') . ' : </label>';
            foreach ($languages as $language) {
                if (!isset($liNameLang[$language['id_lang']]))
                    $liNameLang[$language['id_lang']] = '';
                $this->_html .= '
<div id="OngletsEdit_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;" class="divLang secinput">
<input type="text" id="OngletNameEdit_' . $language['id_lang'] . '" name="OngletNameEdit_' . $language['id_lang'] . '" value="' . $liNameLang[$language['id_lang']] . '" size="40">
</div>';
            }
            $this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'OngletsEdit', 'OngletsEdit', true);
            $this->_html .= '
</p>
<p class="sector_2">
<label>' . $this->l('Link') . ' : </label>
<input type="text" id="LinkPage" name="LinkPage" value="' . $OngletLinks[0]['link'] . '" size="40">
</p>
<p class="sector_3">
<label>' . $this->l('Open link in new Window') . ' : </label>
<input value="1"  class="checker" type="checkbox" id="newin" name="newin" ' . ($OngletLinks[0]['newin'] == '1' ? " checked=\"checked\"" : false) . '>
</p>

';
            $this->_html .= '<table cellpadding="0" cellspacing="1" width="100%">';
            $this->_html .= '<tr><td colspan="2">';
            $this->_html .='

<label style="text-align:left;width:280px; font-weight:bold; font-size:15px;">' . $this->l('Show the Subcategories of the Menu') . ' : </label>
<input style="margin-top:6px;" value="1"  class="checker" type="checkbox" id="custom_open" name="custom_open" ' . ($OngletDetail[0]['custom_open'] == '1' ? " checked=\"checked\"" : false) . '>

<div class="clear"></div>
<div>
<table cellspacing="0" cellpadding="0" class="table" width="100%">
<ul id="prendmoi_ici">';
            $sautdeligne = 0;
            $done = array();
            $index = array();
            $indexedCategories = array();
            $categories = Category::getCategories(intval($cookie->id_lang), false);
            foreach ($indexedCategories AS $k => $row)
                $index[] = $row['id_category'];
            $this->recurseCategory($index, $categories, $categories[0][1], 1, NULL, $liCategorySelected, $liCategoryLine, $liCategoryColumn, $liCategoryTextSubstitute, $liCategoryTextState, $liCategoryViewProducts);
            $this->_html .='
</table>
</div>
</div></div>';
            $this->_html .= '<p align="center"><input name="EnregOngleSett" type="submit" value="' . $this->l('  Save  ') . '" class="button"></p>';
            $this->_html .= '<input type="hidden" value="' . $OngletIdInEdit . '" id="ButttonIdToUpdate" name="ButttonIdToUpdate">';
            $this->_html .= '</td></tr>';
            $this->_html .= '<tr><td class="pos4" colspan="2">&nbsp;<h2 class="select_cat2">' . $this->l('Create new SubMenu Link') . ' : </h2>';
            foreach ($languages as $language) {
                $this->_html .= '<div id="CustomName_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . '; float: left" class="divLang">';
                $this->_html .= '<input type="text" id="CustomMenuName_' . $language['id_lang'] . '" name="CustomMenuName_' . $language['id_lang'] . '">';
                $this->_html .= '</div>';
            }$this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'CustomName', 'CustomName', true);
            $this->_html .= '&nbsp;<input type="button" value="' . $this->l('Add') . '" onclick=\'addCustomMenu("' . $OngletIdInEdit . '")\' class="button">&nbsp;</td></tr>';
            $this->_html .= '<tr><td colspan="2"><BR>';
            $this->_html .= '<div id="tunpipMenu" >';
            $this->_html .= '</div></td></tr></table>';
            $this->_html .= '</form></div></div>';
            $this->_html .= '<form enctype="multipart/form-data" id="form_subTR" name="form_subTR" method="post" action="" style="display : inline"><input type="hidden" name="idOnglet" value="' . $OngletIdInEdit . '"><div style="width: 100%;"><div class="clear"> </div>   <div id="lignh"><div class="presentation_bar"><p>' . $this->l('Setting Top Block') . '</p></div><div class="presentation_cont"><table cellpadding="0" cellspacing="0" width="100%" class="table">';
            $this->_html .= '<tr><td colspan="2" width="100%">';
            foreach ($languages as $language) {
                if (!isset($liDetailSubTrLang[$language['id_lang']]))
                    $liDetailSubTrLang[$language['id_lang']] = '';

                $this->_html .= '
<div id="blockRightTrDiv_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;" class="divLang">
<textarea cols="100" rows="10" id="blockRightTr_' . $language['id_lang'] . '" name="blockRightTr_' . $language['id_lang'] . '">' . $liDetailSubTrLang[$language['id_lang']] . '</textarea>
</div>';
            }
            $this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'blockRightTrDiv', 'blockRightTrDiv', true);
            $this->_html .= '<BR><BR>
';
            $this->_html .= '</td></tr>';
            $this->_html .= '<tr><td colspan="2" align="center"><input type="submit" value="' . $this->l('  Save  ') . '" class="button" name="SubmitDetailSubTr"></td></tr>
</table></div></div></form></div>
<BR>
';
            $this->_html .= '<form enctype="multipart/form-data" id="form_upload_picture" name="form_upload_picture" method="post" action="" style="display : inline">
<div style="width: 100%;">
<div id="lignh2">
<div class="presentation_bar">
<p>' . $this->l('Setting Block Left (Image)') . '</p>
</div>
<div class="presentation_cont">   
<table cellpadding="0" cellspacing="0" width="100%" class="table">
<tr><td width="50%">
<input type="file" id="PictureFile" name="PictureFile" style="font-size : 10px">
<input type="hidden" value="' . urlencode($this->_path) . '" name="AccessPath">
<input type="hidden" value="UploadPicture" name="ActionPicture" id="ActionPicture">
<input type="hidden" name="idOnglet" value="' . $OngletIdInEdit . '">
<input type="hidden" name="NamePicture" value="' . $OngletDetail[0]['img_name'] . '">
<BR><BR>
<label style="float:left; text-align:left; font-size:12px; margin-bottom:5px;">' . $this->l('Link') . ':</label>  <input type="text" id="imgLink" name="imgLink" value="' . urldecode($OngletDetail[0]['img_link']) . '" style="width: 200px">
<BR><BR>
</td>';
            if ($OngletDetail[0]['img_name'] != "") {
                $this->_html .= '<div class="expo_image">';
                $this->_html .= '<img class="emer" src="' . $this->_path . 'images/' . $OngletDetail[0]['img_name'] . '" border="0">';

                $this->_html .= '<span class="delete_my"><img src="../img/admin/disabled.gif" onclick="supprImagesMenu()" style="cursor: pointer">';
                $this->_html .= '</span></div>';
            }
            $this->_html .= '</tr>';

            $this->_html .= '</td></tr>';
            $this->_html .= '<tr><td colspan="2" align="center"><input type="submit" value="' . $this->l('  Save  ') . '" class="button"></td></tr>
</table></div></div></div>
</form>
<BR>
<div class="clear"> </div>   
';
            $this->_html .= '
<form enctype="multipart/form-data" id="form_upload_picture" name="formDetailSub" method="post" action="" style="display : inline">
<div id="lignh3">
<div class="presentation_bar">
<p>' . $this->l('Parametre du Bloc Droit ') . '</p>
</div>
<div class="presentation_cont">   
<table cellpadding="0" cellspacing="0" width="100%" class="table">
<tr><td>';
            foreach ($languages as $language) {
                if (!isset($liDetailSubLang[$language['id_lang']]))
                    $liDetailSubLang[$language['id_lang']] = '';

                $this->_html .= '
<div id="blockRightDiv_' . $language['id_lang'] . '" style="display: ' . ($language['id_lang'] == $defaultLanguage ? 'block' : 'none') . ';float: left;" class="divLang">
<textarea class="rte" cols="100" rows="10" id="blockRight_' . $language['id_lang'] . '" name="blockRight_' . $language['id_lang'] . '">' . $liDetailSubLang[$language['id_lang']] . '</textarea>
</div>';
            }
            $this->_html .= $this->displayFlagsMD($languages, $defaultLanguage, 'blockRightDiv', 'blockRightDiv', true);
            $this->_html .= '<BR><BR>
';
            $this->_html .= '</td></tr>
<tr><td align="center" colspan="2"><input type="hidden" name="idOnglet" value="' . $OngletIdInEdit . '">
<input type="submit" value="' . $this->l('  Save  ') . '" class="button" name="SubmitDetailSub"></td></tr>
</table></div></div><BR></form>';
            $this->_html .= '</fieldset><BR>';
            $this->_html .= '<script>';
            $this->_html .= '$(document).ready(function() { displayDetailMenu(); });';
            $this->_html .= '</script>';
        }
        return$this->_html;
    }

    private function geneMenuImLink($IdLang) {

        /*
          Changed by : Tran Trong Thang
          Email      : trantrongthang1207@gmail.com
         */
        $detect = new Mobile_Detect;
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        $type = isset($_REQUEST['typebrowse']) ? $_REQUEST['typebrowse'] : '';
        if ($type == 'mobile') {
            $deviceType = 'mobile';
        }
        if ($deviceType == 'computer') {
            $rchariot = "\r\n";
            global $cookie, $page_name;
            if (isset($_GET['id_category']))
                $ActiveCategory = intval($_GET['id_category']);
            else
                $ActiveCategory = "";
            if (isset($_GET['id_product'])) {
                if (!isset($cookie->last_visited_category) OR !Product::idIsOnCategoryId(intval($_GET['id_product']), array('0' => array('id_category' => $cookie->last_visited_category)))) {
                    $product = new Product(intval($_GET['id_product']));
                    if (isset($product) AND Validate::isLoadedObject($product))
                        $ActiveCategory = intval($product->id_category_default);
                }
                else {
                    $ActiveCategory = $cookie->last_visited_category;
                }
            }
            if ($ActiveCategory != "") {
                $resultCat = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'menimp_onglet_lkc 
WHERE id_link_cat=' . $ActiveCategory);
            }
            $SettingsM = array();
            $SettingsM = $this->getParameters();
            $SMsettings = array();
            $id_shop = (int) $this->context->shop->id;
            $SMsettings = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'menimp_onglet tb LEFT JOIN ' . _DB_PREFIX_ . 'menimp_onglet_lang tbl 
ON (tb.id_onglet=tbl.id_onglet) 
WHERE tbl.id_lang=' . $IdLang . ' And tbl.id_shop=' . $id_shop . '  ORDER BY posit_onglet ASC, name_onglet ASC');
            if (sizeof($SMsettings)) {
                foreach ($SMsettings as $kOnglet => $ContOnglet) {
                    $liLinkOnglet[$ContOnglet['id_onglet']] = array();
                    $liIdLinkCat[$ContOnglet['id_onglet']] = array();
                    $liLinkCustom[$ContOnglet['id_onglet']] = array();
                    $CatMegaMenu = array();
                    $CatMegaMenu = $this->getOngletLinksCat($ContOnglet['id_onglet']);
                    $LinkOnglet = $this->getOngletLinks($ContOnglet['id_onglet']);


                    if (array_key_exists(0, $LinkOnglet))
                        $linkOnglet = $LinkOnglet[0]['link'];
                    else
                        $linkOnglet = "";
                    $liLinkOnglet[$ContOnglet['id_onglet']][] = basename($linkOnglet);
                    if (sizeof($CatMegaMenu)) {
                        foreach ($CatMegaMenu as $kMenu => $ContCat) {
                            $liIdLinkCat[$ContOnglet['id_onglet']][$ContCat['id_link_cat']] = $ContCat['id_link_cat'];
                            $DescendantCateogries = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'category  
WHERE id_parent=' . $ContCat['id_link_cat']);
                            if (sizeof($DescendantCateogries))
                                foreach ($DescendantCateogries as $kDescCat => $ContDescCat)
                                    $liIdLinkCat[$ContOnglet['id_onglet']][$ContDescCat['id_category']] = $ContDescCat['id_category'];
                        }
                    }
                    $CustomMenu = array();
                    $CustomMenu = $this->getOngletLinksCustom($ContOnglet['id_onglet'], $cookie->id_lang);
                    if (sizeof($CustomMenu)) {
                        foreach ($CustomMenu as $kMenu => $ContMenu) {
                            $liLinkCustom[$ContOnglet['id_onglet']][$ContMenu['id_tunpip']] = basename($ContMenu['link']);
                            $CustomMenuUnder = array();
                            $CustomMenuUnder = $this->getOngletLinksCustomUnder($ContOnglet['id_onglet'], $ContMenu['id_tunpip'], $cookie->id_lang);
                            if (sizeof($CustomMenuUnder))
                                foreach ($CustomMenuUnder as $kDescCustom => $ContDescCustom)
                                    $liLinkCustom[$ContOnglet['id_onglet']][$ContDescCustom['id_tunpip']] = basename($ContDescCustom['link']);
                        }
                    }
                }
            }if (sizeof($SMsettings)) {
                $b = 0;
                foreach ($SMsettings as $kOnglet => $ContOnglet) {

                    $LinkOnglet = $this->getOngletLinks($ContOnglet['id_onglet']);
                    (!array_key_exists(0, $LinkOnglet)) ? $linkOnglet = "#" : $linkOnglet = $LinkOnglet[0]['link'];

                    if (!isset($CustomMenuUnder))
                        $CustomMenuUnder = '';

                    if ($ContOnglet['custom_open'] == "1") {
                        $this->_menuimp .= '<li class="Ogletera calculator_' . $b . '" >' . $rchariot;
                    } else {
                        $this->_menuimp .= '<li class="Ogletera calculator_' . $b . '">' . $rchariot;
                    }strpos(strtolower($ContOnglet['name_onglet']), "<br>") ? $decal = "margin-top : -5px;" : $decal = "";
                    $this->_menuimp .= '<div' . ($decal != 0 ? ' style="' . $decal . '"' : '') . '>

<a';
                    if ($LinkOnglet[0]['newin'] == 1) {
                        $this->_menuimp .= ' target="_blank" ';
                    } $this->_menuimp .= ' href="' . $linkOnglet . '" ' . ($linkOnglet == "#" ? "onclick='return false'" : false) . ' class="buttons ';
                    if ($ContOnglet['custom_open'] == "1") {
                        $this->_menuimp .= 'padding15';
                    }$this->_menuimp .= '" ' . (in_array($ActiveCategory, $liIdLinkCat[$ContOnglet['id_onglet']]) || in_array(basename($_SERVER['REQUEST_URI']), $liLinkCustom[$ContOnglet['id_onglet']]) || in_array(basename($_SERVER['REQUEST_URI']), $liLinkOnglet[$ContOnglet['id_onglet']]) ? '"' : false ) . '>' . $ContOnglet['name_onglet'] . '</a></div>' . $rchariot;
                    $CatMegaMenu = array();
                    $CatMegaMenu = $this->getOngletLinksCat($ContOnglet['id_onglet']);
                    $CustomMenu = array();
                    $CustomMenu = $this->getOngletLinksCustom($ContOnglet['id_onglet'], $cookie->id_lang);
                    $NbColsMaximum = $this->getMaximumColumns($ContOnglet['id_onglet']);
                    $MaximumCols = 0;
                    $MaximumLines = 0;
                    $liLines = array();
                    $m = 0;
                    if (sizeof($CatMegaMenu)) {
                        foreach ($CatMegaMenu as $kMenu => $ContCat) {
                            $liLines[$kOnglet][$ContCat['pla_lin']] = $ContCat['pla_lin'];
                            $liLinesOrder[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']] = $ContCat['pla_col'];
                            $liLinesDatas[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']][$m] = $ContCat;
                            $liLinesType[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']][$m] = 'category';
                            $liColumn[$kOnglet][$ContCat['pla_lin']] = $ContCat['pla_col'];
                            $liColumnOrder[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']] = $ContCat['pla_lin'];
                            $liColumnDatas[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']][$m] = $ContCat;
                            $liColumnType[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']][$m] = 'category';
                            $m++;
                            $MaximumCols < ($ContCat['pla_col'] * 1) ? $MaximumCols = $ContCat['pla_col'] : false;
                            $MaximumLines < ($ContCat['pla_lin'] * 1) ? $MaximumLines = $ContCat['pla_lin'] : false;
                        }
                    }
                    if (sizeof($CustomMenu)) {
                        foreach ($CustomMenu as $kCustom => $ContCustom) {
                            $liLines[$kOnglet][$ContCustom['pla_lin']] = $ContCustom['pla_lin'];
                            $liLinesOrder[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']] = $ContCustom['pla_col'];
                            $liLinesDatas[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']][$m] = $ContCustom;
                            $liLinesType[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']][$m] = 'tunpip';
                            $liColumn[$kOnglet][$ContCustom['pla_lin']] = $ContCustom['pla_col'];
                            $liColumnOrder[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']] = $ContCustom['pla_lin'];
                            $liColumnDatas[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']][$m] = $ContCustom;
                            $liColumnType[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']][$m] = 'tunpip';
                            $m++;
                            $MaximumCols < ($ContCustom['pla_col'] * 1) ? $MaximumCols = $ContCustom['pla_col'] : false;
                            $MaximumLines < ($ContCustom['pla_lin'] * 1) ? $MaximumLines = $ContCustom['pla_lin'] : false;
                        }
                    }if (array_key_exists($kOnglet, $liLines))
                        if (sizeof($liLines[$kOnglet])) {
                            if ($ContOnglet['custom_open'] == "1") {

                                if ($MaximumCols > '0') {
                                    $this->_menuimp .= '<span class="sub-indicator"> �</span>' . $rchariot;
                                }if ($ContOnglet['img_name'] != '') {
                                    if ($MaximumCols == '1') {
                                        $this->_menuimp .= '<div class="enbas AveCcolA" >' . $rchariot;
                                    } elseif ($MaximumCols == '2') {
                                        $this->_menuimp .= '<div class="enbas AveCcolB" >' . $rchariot;
                                    } elseif ($MaximumCols == '3') {
                                        $this->_menuimp .= '<div class="enbas AveCcolC" >' . $rchariot;
                                    } elseif ($MaximumCols > '3') {
                                        $this->_menuimp .= '<div class="enbas AveCcolD" >' . $rchariot;
                                    }
                                } else {
                                    if ($MaximumCols == '1') {
                                        $this->_menuimp .= '<div class="enbas ';
                                        if ($ContOnglet['blockTop'] != '') {
                                            $this->_menuimp .= 'Prbradius';
                                        }$this->_menuimp .=' SanScolA" >' . $rchariot;
                                    } elseif ($MaximumCols == '2') {
                                        $this->_menuimp .= '<div class="enbas ';
                                        if ($ContOnglet['blockTop'] != '') {
                                            $this->_menuimp .= 'Prbradius';
                                        }$this->_menuimp .=' SanScolB" >' . $rchariot;
                                    } elseif ($MaximumCols == '3') {
                                        $this->_menuimp .= '<div class="enbas SanScolC" >' . $rchariot;
                                    } elseif ($MaximumCols > '3') {
                                        $this->_menuimp .= '<div class="enbas SanScolD" >' . $rchariot;
                                    }
                                }$this->_menuimp .= '<div class="img_left_cont">' . $rchariot;
                                if ($ContOnglet['img_name'] != '') {
                                    if ($ContOnglet['img_link'] != '')
                                        $this->_menuimp .= '<a href="' . urldecode($ContOnglet['img_link']) . '" style="float:none; margin:0; padding:0">';$this->_menuimp .= '<img src="' . $this->_path . 'images/' . $ContOnglet['img_name'] . '" style="border:0px" alt="' . $ContOnglet['img_name'] . '"/>' . $rchariot;
                                    if ($ContOnglet['img_link'] != '')
                                        $this->_menuimp .= '</a>';
                                }$this->_menuimp .= html_entity_decode($ContOnglet['blockLeft']) . '</div>';
                                if ($MaximumCols == '2') {
                                    $this->_menuimp .= '<table class="TableBig" ><span class="separa"></span>';
                                } else {
                                    $this->_menuimp .= '<table class="TableBig" >';
                                }if ($ContOnglet['blockTop'] != '') {
                                    $this->_menuimp .= '<div class="decr_top_cont">';
                                    $this->_menuimp .= '<p>' . $rchariot;
                                    $this->_menuimp .= $ContOnglet['blockTop'] == "" ? "&nbsp;" : html_entity_decode($ContOnglet['blockTop']);
                                    $this->_menuimp .= '' . ($ContOnglet['blockRight'] == "" ? "&nbsp;" : html_entity_decode($ContOnglet['blockRight'])) . '' . $rchariot;
                                    $this->_menuimp .= '</p></div>';
                                } else {
                                    
                                }$this->_menuimp .= '<td class="mpMd2" valign="top"><table class="MpMEL"><tr>' . $rchariot;
                                for ($c = 1; $c <= $MaximumCols; $c++) {
                                    $this->_menuimp .= '<td valign="top">' . $rchariot;
                                    for ($l = 1; $l <= $MaximumLines; $l++) {
                                        if (array_key_exists($c, $liColumnDatas[$kOnglet]))
                                            if (array_key_exists($l, $liColumnDatas[$kOnglet][$c]))
                                                if (sizeof(@$liColumnDatas[$kOnglet][$c][$l])) {
                                                    $this->_menuimp .= '<table border="0" >' . $rchariot;
                                                    foreach ($liColumnDatas[$kOnglet][$c][$l] as $keyMenu => $ContMenu) {
                                                        $this->_menuimp .= '<tr>' . $rchariot;
                                                        $this->_menuimp .= '<td>' . $rchariot;
                                                        switch ($liColumnType[$kOnglet][$c][$l][$keyMenu]) {
                                                            case 'category':$this->_menuimp .= '<ul class="cat_cont"  id="catuu_' . $keyMenu . '">' . $rchariot;
                                                                $NameCategory = $this->getNameCategory($ContMenu['id_link_cat'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                $NameSubstitute = $this->getNameSubstitute($ContMenu['id_link_cat'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                $Category = new Category(intval($ContMenu['id_link_cat']), intval($cookie->id_lang));
                                                                $rewrited_url = $this->getCategoryLinkMD($ContMenu['id_link_cat'], $Category->catalog / link_rewrite);
                                                                $this->_menuimp .= '<li class="stitle"><a href="' . $rewrited_url . '" >' . (trim($NameSubstitute[0]['renommer']) != '' ? $NameSubstitute[0]['renommer'] : $NameCategory[0]['name']) . '</a></li>' . $rchariot;
                                                                if ($ContMenu['accr_prod'] != '') {
                                                                    
                                                                } else {
                                                                    $NameCategoryUnder = array();
                                                                    $NameCategoryUnder = $this->getNameCategoryUnder($ContMenu['id_link_cat'], $ContOnglet['id_onglet']);
                                                                    if (sizeof($NameCategoryUnder)) {
                                                                        foreach ($NameCategoryUnder as $KUnderCat => $ContUnderCat) {
                                                                            $Category = new Category(intval($ContUnderCat['id_category']), intval($cookie->id_lang));
//                                                                            print_r($Category);
//                                                                            exit();
                                                                            $rewrited_url = $this->getCategoryLinkMD($ContUnderCat['id_category'], $Category->catalog / link_rewrite);
//                                                                            echo $rewrited_url;
//                                                                            exit();
                                                                            $NameCategoryUnder = $this->getNameCategory($ContUnderCat['id_category'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                            $NameSubstitute = $this->getNameSubstitute($ContUnderCat['id_category'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                            $this->_menuimp .= '<li><a href="' . $rewrited_url . '" >' . (trim($NameSubstitute[0]['renommer']) != '' ? $NameSubstitute[0]['renommer'] : $NameCategoryUnder[0]['name']) . '</a></li>' . $rchariot;
                                                                        }
                                                                    }
                                                                }$this->_menuimp .= '</ul>' . $rchariot;
                                                                break;
                                                            case 'tunpip':$this->_menuimp .= '<ul class="cat_cont" id="catuu_' . $keyMenu . '">' . $rchariot;
                                                                $this->_menuimp .= '<li class="stitle"><a href="' . $ContMenu['link'] . '" ' . ($ContMenu['link'] == "#" || $ContMenu['link'] == "" ? "onclick='return false'" : false) . ' >' . $ContMenu['name_menu'] . '</a></li>' . $rchariot;
                                                                $NameLinkUnder = array();
                                                                $NameLinkUnder = $this->getOngletLinksCustomUnder($ContOnglet['id_onglet'], $ContMenu['id_tunpip'], $cookie->id_lang);
                                                                if (sizeof($NameLinkUnder)) {
                                                                    foreach ($NameLinkUnder as $KUnderLink => $ContUnderLink)
                                                                        $this->_menuimp .= '<li><a href="' . $ContUnderLink['link'] . '" ' . ($ContUnderLink['link'] == "#" || $ContUnderLink['link'] == "" ? "onclick='return false'" : false) . ' >' . $ContUnderLink['name_menu'] . '</a></li>' . $rchariot;
                                                                }$this->_menuimp .= '</ul>' . $rchariot;
                                                                break;
                                                        }$this->_menuimp .= '</td></tr>' . $rchariot;
                                                    }$this->_menuimp .= '</table>' . $rchariot;
                                                }
                                    }$this->_menuimp .= '</td>' . $rchariot;
                                }$this->_menuimp .= '</tr></table></td></tr></table></div>' . $rchariot;
                            }$this->_menuimp .= '' . $rchariot;
                            $b++;
                        }
                }$this->_menuimp .= '</div>' . $rchariot;
            }
        } else {
            $rchariot = "\r\n";
            global $cookie, $page_name;
            if (isset($_GET['id_category']))
                $ActiveCategory = intval($_GET['id_category']);
            else
                $ActiveCategory = "";
            if (isset($_GET['id_product'])) {
                if (!isset($cookie->last_visited_category) OR !Product::idIsOnCategoryId(intval($_GET['id_product']), array('0' => array('id_category' => $cookie->last_visited_category)))) {
                    $product = new Product(intval($_GET['id_product']));
                    if (isset($product) AND Validate::isLoadedObject($product))
                        $ActiveCategory = intval($product->id_category_default);
                }
                else {
                    $ActiveCategory = $cookie->last_visited_category;
                }
            }
            if ($ActiveCategory != "") {
                $resultCat = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'menimp_onglet_lkc 
WHERE id_link_cat=' . $ActiveCategory);
            }
            $SettingsM = array();
            $SettingsM = $this->getParameters();
            $SMsettings = array();
            $id_shop = (int) $this->context->shop->id;
            $SMsettings = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'menimp_onglet tb LEFT JOIN ' . _DB_PREFIX_ . 'menimp_onglet_lang tbl 
ON (tb.id_onglet=tbl.id_onglet) 
WHERE tbl.id_lang=' . $IdLang . ' And tbl.id_shop=' . $id_shop . '  ORDER BY posit_onglet ASC, name_onglet ASC');
            if (sizeof($SMsettings)) {
                foreach ($SMsettings as $kOnglet => $ContOnglet) {
                    $liLinkOnglet[$ContOnglet['id_onglet']] = array();
                    $liIdLinkCat[$ContOnglet['id_onglet']] = array();
                    $liLinkCustom[$ContOnglet['id_onglet']] = array();
                    $CatMegaMenu = array();
                    $CatMegaMenu = $this->getOngletLinksCat($ContOnglet['id_onglet']);
                    $LinkOnglet = $this->getOngletLinks($ContOnglet['id_onglet']);


                    if (array_key_exists(0, $LinkOnglet))
                        $linkOnglet = $LinkOnglet[0]['link'];
                    else
                        $linkOnglet = "";
                    $liLinkOnglet[$ContOnglet['id_onglet']][] = basename($linkOnglet);
                    if (sizeof($CatMegaMenu)) {
                        foreach ($CatMegaMenu as $kMenu => $ContCat) {
                            $liIdLinkCat[$ContOnglet['id_onglet']][$ContCat['id_link_cat']] = $ContCat['id_link_cat'];
                            $DescendantCateogries = Db::getInstance()->ExecuteS('
SELECT *  
FROM ' . _DB_PREFIX_ . 'category  
WHERE id_parent=' . $ContCat['id_link_cat']);
                            if (sizeof($DescendantCateogries))
                                foreach ($DescendantCateogries as $kDescCat => $ContDescCat)
                                    $liIdLinkCat[$ContOnglet['id_onglet']][$ContDescCat['id_category']] = $ContDescCat['id_category'];
                        }
                    }
                    $CustomMenu = array();
                    $CustomMenu = $this->getOngletLinksCustom($ContOnglet['id_onglet'], $cookie->id_lang);
                    if (sizeof($CustomMenu)) {
                        foreach ($CustomMenu as $kMenu => $ContMenu) {
                            $liLinkCustom[$ContOnglet['id_onglet']][$ContMenu['id_tunpip']] = basename($ContMenu['link']);
                            $CustomMenuUnder = array();
                            $CustomMenuUnder = $this->getOngletLinksCustomUnder($ContOnglet['id_onglet'], $ContMenu['id_tunpip'], $cookie->id_lang);
                            if (sizeof($CustomMenuUnder))
                                foreach ($CustomMenuUnder as $kDescCustom => $ContDescCustom)
                                    $liLinkCustom[$ContOnglet['id_onglet']][$ContDescCustom['id_tunpip']] = basename($ContDescCustom['link']);
                        }
                    }
                }
            }if (sizeof($SMsettings)) {
                $b = 0;
                foreach ($SMsettings as $kOnglet => $ContOnglet) {

                    $LinkOnglet = $this->getOngletLinks($ContOnglet['id_onglet']);
                    (!array_key_exists(0, $LinkOnglet)) ? $linkOnglet = "#" : $linkOnglet = $LinkOnglet[0]['link'];

                    if (!isset($CustomMenuUnder))
                        $CustomMenuUnder = '';

                    if ($ContOnglet['custom_open'] == "1") {
                        $this->_menuimp .= '<li class="Ogletera calculator_' . $b . '" >' . $rchariot;
                    } else {
                        $this->_menuimp .= '<li class="Ogletera calculator_' . $b . '">' . $rchariot;
                    }strpos(strtolower($ContOnglet['name_onglet']), "<br>") ? $decal = "margin-top : -5px;" : $decal = "";
                    $this->_menuimp .= '<div' . ($decal != 0 ? ' style="' . $decal . '"' : '') . '>

<a';
                    if ($LinkOnglet[0]['newin'] == 1) {
                        $this->_menuimp .= ' target="_blank" ';
                    } $this->_menuimp .= ' href="' . $linkOnglet . '" ' . ($linkOnglet == "#" ? "onclick='return false'" : false) . ' class="buttons ';
                    if ($ContOnglet['custom_open'] == "1") {
                        $this->_menuimp .= 'padding15';
                    }$this->_menuimp .= '" ' . (in_array($ActiveCategory, $liIdLinkCat[$ContOnglet['id_onglet']]) || in_array(basename($_SERVER['REQUEST_URI']), $liLinkCustom[$ContOnglet['id_onglet']]) || in_array(basename($_SERVER['REQUEST_URI']), $liLinkOnglet[$ContOnglet['id_onglet']]) ? '"' : false ) . '>' . $ContOnglet['name_onglet'] . '</a></div>' . $rchariot;
                    $CatMegaMenu = array();
                    $CatMegaMenu = $this->getOngletLinksCat($ContOnglet['id_onglet']);
                    $CustomMenu = array();
                    $CustomMenu = $this->getOngletLinksCustom($ContOnglet['id_onglet'], $cookie->id_lang);
                    $NbColsMaximum = $this->getMaximumColumns($ContOnglet['id_onglet']);
                    $MaximumCols = 0;
                    $MaximumLines = 0;
                    $liLines = array();
                    $m = 0;
                    if (sizeof($CatMegaMenu)) {
                        foreach ($CatMegaMenu as $kMenu => $ContCat) {
                            $liLines[$kOnglet][$ContCat['pla_lin']] = $ContCat['pla_lin'];
                            $liLinesOrder[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']] = $ContCat['pla_col'];
                            $liLinesDatas[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']][$m] = $ContCat;
                            $liLinesType[$kOnglet][$ContCat['pla_lin']][$ContCat['pla_col']][$m] = 'category';
                            $liColumn[$kOnglet][$ContCat['pla_lin']] = $ContCat['pla_col'];
                            $liColumnOrder[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']] = $ContCat['pla_lin'];
                            $liColumnDatas[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']][$m] = $ContCat;
                            $liColumnType[$kOnglet][$ContCat['pla_col']][$ContCat['pla_lin']][$m] = 'category';
                            $m++;
                            $MaximumCols < ($ContCat['pla_col'] * 1) ? $MaximumCols = $ContCat['pla_col'] : false;
                            $MaximumLines < ($ContCat['pla_lin'] * 1) ? $MaximumLines = $ContCat['pla_lin'] : false;
                        }
                    }
                    if (sizeof($CustomMenu)) {
                        foreach ($CustomMenu as $kCustom => $ContCustom) {
                            $liLines[$kOnglet][$ContCustom['pla_lin']] = $ContCustom['pla_lin'];
                            $liLinesOrder[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']] = $ContCustom['pla_col'];
                            $liLinesDatas[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']][$m] = $ContCustom;
                            $liLinesType[$kOnglet][$ContCustom['pla_lin']][$ContCustom['pla_col']][$m] = 'tunpip';
                            $liColumn[$kOnglet][$ContCustom['pla_lin']] = $ContCustom['pla_col'];
                            $liColumnOrder[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']] = $ContCustom['pla_lin'];
                            $liColumnDatas[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']][$m] = $ContCustom;
                            $liColumnType[$kOnglet][$ContCustom['pla_col']][$ContCustom['pla_lin']][$m] = 'tunpip';
                            $m++;
                            $MaximumCols < ($ContCustom['pla_col'] * 1) ? $MaximumCols = $ContCustom['pla_col'] : false;
                            $MaximumLines < ($ContCustom['pla_lin'] * 1) ? $MaximumLines = $ContCustom['pla_lin'] : false;
                        }
                    }if (array_key_exists($kOnglet, $liLines))
                        if (sizeof($liLines[$kOnglet])) {
                            if ($ContOnglet['custom_open'] == "1") {

                                if ($MaximumCols > '0') {
                                    $this->_menuimp .= '<span class="sub-indicator"> ï¿½</span>' . $rchariot;
                                }if ($ContOnglet['img_name'] != '') {
                                    if ($MaximumCols == '1') {
                                        $this->_menuimp .= '<div class="enbas AveCcolA" >' . $rchariot;
                                    } elseif ($MaximumCols == '2') {
                                        $this->_menuimp .= '<div class="enbas AveCcolB" >' . $rchariot;
                                    } elseif ($MaximumCols == '3') {
                                        $this->_menuimp .= '<div class="enbas AveCcolC" >' . $rchariot;
                                    } elseif ($MaximumCols > '3') {
                                        $this->_menuimp .= '<div class="enbas AveCcolD" >' . $rchariot;
                                    }
                                } else {
                                    if ($MaximumCols == '1') {
                                        $this->_menuimp .= '<div class="enbas ';
                                        if ($ContOnglet['blockTop'] != '') {
                                            $this->_menuimp .= 'Prbradius';
                                        }$this->_menuimp .=' SanScolA" >' . $rchariot;
                                    } elseif ($MaximumCols == '2') {
                                        $this->_menuimp .= '<div class="enbas ';
                                        if ($ContOnglet['blockTop'] != '') {
                                            $this->_menuimp .= 'Prbradius';
                                        }$this->_menuimp .=' SanScolB" >' . $rchariot;
                                    } elseif ($MaximumCols == '3') {
                                        $this->_menuimp .= '<div class="enbas SanScolC" >' . $rchariot;
                                    } elseif ($MaximumCols > '3') {
                                        $this->_menuimp .= '<div class="enbas SanScolD" >' . $rchariot;
                                    }
                                }$this->_menuimp .= '<div class="img_left_cont">' . $rchariot;
                                if ($ContOnglet['img_name'] != '') {
                                    if ($ContOnglet['img_link'] != '')
                                        $this->_menuimp .= '<a href="' . urldecode($ContOnglet['img_link']) . '" style="float:none; margin:0; padding:0">';$this->_menuimp .= '<img src="' . $this->_path . 'images/' . $ContOnglet['img_name'] . '" style="border:0px" alt="' . $ContOnglet['img_name'] . '"/>' . $rchariot;
                                    if ($ContOnglet['img_link'] != '')
                                        $this->_menuimp .= '</a>';
                                }$this->_menuimp .= html_entity_decode($ContOnglet['blockLeft']) . '</div>';
                                if ($MaximumCols == '2') {
                                    $this->_menuimp .= '<div class="TableBig" ><span class="separa"></span>';
                                } else {
                                    $this->_menuimp .= '<div class="TableBig" >';
                                }if ($ContOnglet['blockTop'] != '') {
                                    $this->_menuimp .= '<div class="decr_top_cont">';
                                    $this->_menuimp .= '<p>' . $rchariot;
                                    $this->_menuimp .= $ContOnglet['blockTop'] == "" ? "&nbsp;" : html_entity_decode($ContOnglet['blockTop']);
                                    $this->_menuimp .= '' . ($ContOnglet['blockRight'] == "" ? "&nbsp;" : html_entity_decode($ContOnglet['blockRight'])) . '' . $rchariot;
                                    $this->_menuimp .= '</p></div>';
                                } else {
                                    
                                }
                                //Thuc hien phan dong cho menu
                                $this->_menuimp .= '<div class="mpMd2 MpMEL mnrow">';
                                //moi dong duoc hien thi trong mot table
                                //Chia so cot se duoc hien thi tren not menu
                                for ($c = 1; $c <= $MaximumCols; $c++) {
                                    //Thuc hien phan cot cho menu
                                    //moi cot hien thi trong mot td
                                    //$this->_menuimp .= '<td valign="top">' . $rchariot;
                                    $this->_menuimp .= '<div class="mncol col_' . $c . '">' . $rchariot;
                                    for ($l = 1; $l <= $MaximumLines; $l++) {
                                        if (array_key_exists($c, $liColumnDatas[$kOnglet]))
                                            if (array_key_exists($l, $liColumnDatas[$kOnglet][$c]))
                                                if (sizeof(@$liColumnDatas[$kOnglet][$c][$l])) {
                                                    //Thuc hien phan cot theo dong
                                                    $this->_menuimp .= '<div class="colrow col_row' . $l . '">' . $rchariot;
                                                    foreach ($liColumnDatas[$kOnglet][$c][$l] as $keyMenu => $ContMenu) {
                                                        switch ($liColumnType[$kOnglet][$c][$l][$keyMenu]) {
                                                            case 'category':
                                                                $this->_menuimp .= '<ul class="cat_cont"  id="catuu_' . $keyMenu . '">' . $rchariot;
                                                                $NameCategory = $this->getNameCategory($ContMenu['id_link_cat'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                $NameSubstitute = $this->getNameSubstitute($ContMenu['id_link_cat'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                $Category = new Category(intval($ContMenu['id_link_cat']), intval($cookie->id_lang));
                                                                $rewrited_url = $this->getCategoryLinkMD($ContMenu['id_link_cat'], $Category->catalog / link_rewrite);
                                                                $this->_menuimp .= '<li class="stitle"><a href="' . $rewrited_url . '" >' . (trim($NameSubstitute[0]['renommer']) != '' ? $NameSubstitute[0]['renommer'] : $NameCategory[0]['name']) . '</a></li>' . $rchariot;
                                                                if ($ContMenu['accr_prod'] != '') {
                                                                    
                                                                } else {
                                                                    $NameCategoryUnder = array();
                                                                    $NameCategoryUnder = $this->getNameCategoryUnder($ContMenu['id_link_cat'], $ContOnglet['id_onglet']);
                                                                    if (sizeof($NameCategoryUnder)) {
                                                                        foreach ($NameCategoryUnder as $KUnderCat => $ContUnderCat) {
                                                                            $Category = new Category(intval($ContUnderCat['id_category']), intval($cookie->id_lang));
                                                                            $rewrited_url = $this->getCategoryLinkMD($ContUnderCat['id_category'], $Category->catalog / link_rewrite);
                                                                            $NameCategoryUnder = $this->getNameCategory($ContUnderCat['id_category'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                            $NameSubstitute = $this->getNameSubstitute($ContUnderCat['id_category'], $cookie->id_lang, $ContOnglet['id_onglet']);
                                                                            $this->_menuimp .= '<li><a href="' . $rewrited_url . '" >' . (trim($NameSubstitute[0]['renommer']) != '' ? $NameSubstitute[0]['renommer'] : $NameCategoryUnder[0]['name']) . '</a></li>' . $rchariot;
                                                                        }
                                                                    }
                                                                }$this->_menuimp .= '</ul>' . $rchariot;
                                                                break;
                                                            case 'tunpip':
                                                                $this->_menuimp .= '<ul class="cat_cont" id="catuu_' . $keyMenu . '">' . $rchariot;
                                                                $this->_menuimp .= '<li class="stitle"><a href="' . $ContMenu['link'] . '" ' . ($ContMenu['link'] == "#" || $ContMenu['link'] == "" ? "onclick='return false'" : false) . ' >' . $ContMenu['name_menu'] . '</a></li>' . $rchariot;
                                                                $NameLinkUnder = array();
                                                                $NameLinkUnder = $this->getOngletLinksCustomUnder($ContOnglet['id_onglet'], $ContMenu['id_tunpip'], $cookie->id_lang);
                                                                if (sizeof($NameLinkUnder)) {
                                                                    foreach ($NameLinkUnder as $KUnderLink => $ContUnderLink)
                                                                        $this->_menuimp .= '<li><a href="' . $ContUnderLink['link'] . '" ' . ($ContUnderLink['link'] == "#" || $ContUnderLink['link'] == "" ? "onclick='return false'" : false) . ' >' . $ContUnderLink['name_menu'] . '</a></li>' . $rchariot;
                                                                }$this->_menuimp .= '</ul>' . $rchariot;
                                                                break;
                                                        }
                                                    }
                                                    $this->_menuimp .= '</div>' . $rchariot;
                                                }
                                    }

                                    $this->_menuimp .= '</div>' . $rchariot;
                                }
                                $this->_menuimp .= '</div>';
                                $this->_menuimp .= '</div>';
                                $this->_menuimp .= '</div>' . $rchariot;
                            }
                            $this->_menuimp .= '' . $rchariot;
                            $b++;
                        }
                }
                $this->_menuimp .= '</div>' . $rchariot;
            }
        }
    }

    public function hookTop($param) {
        global $smarty, $cookie;
        $this->geneMenuImLink($cookie->id_lang);
        $SettingsM = array();
        $SettingsM = $this->getParameters();
        $smarty->assign('menuimpact_Gen', $this->_menuimp);
        return $this->display(__FILE__, 'menuimpact.tpl');
    }

    function hookHeader($params) {
        global $smarty, $cookie;
        $SettingsM = array();
        $SettingsM = $this->getParameters();
        $smarty->assign('menuimpact_Gen', $this->_menuimp);
        $this->context->controller->addJS(($this->_path) . 'js/menuimp.js');
        $this->context->controller->addCss($this->_path . 'css/front/menuimpact.css');
    }

}

?>