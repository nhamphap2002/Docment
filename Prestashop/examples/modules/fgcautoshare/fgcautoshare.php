<?php
/**
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
if (!defined('_PS_VERSION_'))
    exit;

require_once dirname(__FILE__) . '/tables/table_channels.php';
require_once dirname(__FILE__) . '/tables/table_channeltypes.php';
require_once dirname(__FILE__) . '/tables/table_queues.php';
require_once dirname(__FILE__) . '/tables/table_requests.php';
require_once dirname(__FILE__) . '/tables/table_ruletypes.php';
require_once dirname(__FILE__) . '/tables/table_rules.php';

require_once dirname(__FILE__) . "/helpers/globalvariables.php";

require_once dirname(__FILE__) . '/models/channels.php';
require_once dirname(__FILE__) . '/models/channeltypes.php';
require_once dirname(__FILE__) . '/models/requests.php';
require_once dirname(__FILE__) . '/models/queues.php';
require_once dirname(__FILE__) . '/models/ruletypes.php';
require_once dirname(__FILE__) . '/models/rules.php';

require_once dirname(__FILE__) . '/helpers/helpers.php';
require_once dirname(__FILE__) . "/helpers/helperSocials.php";
require_once dirname(__FILE__) . "/helpers/shorturl.php";

class fgcAutoshare extends Module {

    public function __construct() {
        $this->name = 'fgcautoshare';
        $this->tab = 'advertising_marketing';
        $this->version = '1.0.0';
        $this->author = 'FGCTechlution';
        $this->need_instance = 0;
        $this->module_key = "ce5e3477eeb1ed3f98e266bff2a05995";
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

        parent::__construct();
        $this->displayName = $this->l('FGC auto share');
        $this->description = $this->l('The Fgcautoshare product series posts title, text, images and url for new/edited Prestashop product, forum posts etc. automatically as status messages to Twitter, Facebook, LinkedIn, E-Mail accounts and other social channels.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete all settings and your logs?');
    }

    /**
     * install
     * @return type
     */
    public function install() {
        Configuration::updateValue('PS_FGCAUTOSHARE_SECURE_KEY', strtoupper(Tools::passwdGen(16)));
        return (parent::install() && $this->registerHook('displayBackOfficeHeader') && $this->createTable() && $this->registerHook('actionProductDelete') && $this->registerHook('actionProductAdd') && $this->registerHook('actionProductUpdate')
                );
    }

    /**
     * uninstall
     * @return type
     */
    public function uninstall() {
        Configuration::deleteByName('PS_FGCAUTOSHARE_SECURE_KEY');
        return (parent::uninstall() && $this->deleteTable());
    }

    /**
     * hook product delete
     * @param type $product
     */
    public function hookactionProductDelete($product) {
        $full_obj_product = $product['product'];
        if (!empty($full_obj_product)) {
            FgcautosharerequestsModel::deleteByProductIds(array($full_obj_product->id));
            FgcautosharequeuesModel::deleteByProduct(array($full_obj_product->id));
        }
    }

    /**
     * hook product add
     * @global type $cookie
     * @param type $product
     */
    public function hookactionProductAdd($product) {
        $full_obj_product = $product['product'];
        if (!empty($full_obj_product)) {
            $product_info_temp = $this->getProductInfo($full_obj_product->id);
            $obj_product_for_request = FGCAutoshareHelpers::buildDataProduct($full_obj_product, $product_info_temp);
            global $cookie;
            $employ_id = $cookie->id_employee;
            $data = FGCAutoshareHelpers::buildDataForRequest($obj_product_for_request, $employ_id);
            unset($data['modified']);
            unset($data['modified_by']);
            FgcautosharerequestsModel::insert($data);
        }
    }

    /**
     * hook product update
     * @global type $cookie
     * @param type $product
     */
    public function hookactionProductUpdate($product) {
        $full_obj_product = $product['product'];
        if (!empty($full_obj_product)) {
            $product_info_temp = $this->getProductInfo($full_obj_product->id);
            $obj_product_for_request = FGCAutoshareHelpers::buildDataProduct($full_obj_product, $product_info_temp);
            global $cookie;
            $employ_id = $cookie->id_employee;
            $data = FGCAutoshareHelpers::buildDataForRequest($obj_product_for_request, $employ_id);
            if ($id = FgcautosharerequestsModel::isExists($obj_product_for_request['id'])) {
                unset($data['created']);
                unset($data['created_by']);
                unset($data['order']);
                $data['id'] = $id;
                FgcautosharerequestsModel::update($data);
            } else {
                unset($data['modified']);
                unset($data['modified_by']);
                FgcautosharerequestsModel::insert($data);
            }
        }
    }

    /**
     * get module content for backend
     * @global type $cookie
     * @global type $cookie
     * @return type
     */
    public function getContent() {

        $adminLink = $this->getAdminLink();
        $output = '';
        if (Tools::isSubmit('add_new_channel')) {
            $data = $_POST;
            if ($data['name'] != '') {
                $data['created'] = date('Y-m-d H:i:s');
                global $cookie;
                $data['created_by'] = $cookie->id_employee;
                $data['params'] = FGCAutoshareHelpers::buildJsonParams($data['autoshare_channeltype_id'], $data);
                if ($data['status'] == '') {
                    $data['status'] = 'not_verified';
                }
                FgcautosharechannelsModel::insert($data);
                $output = $this->displayConfirmation($this->l('Add success!'));
            } else {
                $output = $this->displayError($this->l('Add Unsuccess!'));
            }
            $_REQUEST['action'] = null;
        } elseif (Tools::isSubmit('update_channel')) {
            $data = $_POST;
            if ($data['name'] != '') {
                $data['modified'] = date('Y-m-d H:i:s');
                global $cookie;
                $data['modified_by'] = $cookie->id_employee;
                $data['params'] = FGCAutoshareHelpers::buildJsonParams($data['autoshare_channeltype_id'], $data);
                FgcautosharechannelsModel::update($data);
                $output = $this->displayConfirmation($this->l('Update success!'));
            } else {
                $output = $this->displayError($this->l('Update Unsuccess!'));
            }
            $_REQUEST['action'] = null;
        } elseif (Tools::isSubmit('delete_channels')) {
            $data = $_POST;
            if (count($data['channel_ids']) > 0) {
                FgcautosharechannelsModel::delete($data['channel_ids']);
                FgcautosharequeuesModel::deleteByChannelId($data['channel_ids']);
                FgcautoshareruleModel::deleteByChannelId($data['channel_ids']);
                $output = $this->displayConfirmation($this->l('Delete success!'));
            } else {
                $output = $this->displayError($this->l('Delete Unsuccess!'));
            }
            $_REQUEST['action'] = null;
        } elseif (Tools::isSubmit('delete_requests')) {
            $data = $_POST;
            if (count($data['requests_ids']) > 0) {
                $product_ids = FgcautosharerequestsModel::getProductIdByRequestId($data['requests_ids']);
                FgcautosharerequestsModel::delete($data['requests_ids']);
                FgcautosharequeuesModel::deleteByProduct($product_ids);
                $output = $this->displayConfirmation($this->l('Delete success!'));
            } else {
                $output = $this->displayError($this->l('Delete Unsuccess!'));
            }
        } elseif (Tools::isSubmit('delete_queues')) {
            $data = $_POST;
            if (count($data['queues_ids']) > 0) {
                FgcautosharequeuesModel::delete($data['queues_ids']);
                $output = $this->displayConfirmation($this->l('Delete success!'));
            } else {
                $output = $this->displayError($this->l('Delete Unsuccess!'));
            }
        } elseif (Tools::isSubmit('add_new_rule')) {
            $data = $_POST;
            if ($data['name'] != '' && $data['condition'] != '') {
                $data['created'] = date('Y-m-d H:i:s');
                global $cookie;
                $data['created_by'] = $cookie->id_employee;
                if ($data['autoshare_ruletype_id'] == 3 && count(explode(",", $data['condition'])) != 2) {
                    $output = $this->displayError($this->l('Add Unsuccess!'));
                } else {
                    if (!FgcautoshareruleModel::checkExistRuleOfChannel($data['autoshare_channel_id'], $data['autoshare_ruletype_id'])) {
                        FgcautoshareruleModel::insert($data);
                        $output = $this->displayConfirmation($this->l('Add success!'));
                    } else {
                        $output = $this->displayError($this->l('Rule exist!'));
                    }
                }
            } else {
                $output = $this->displayError($this->l('Add Unsuccess!'));
            }
            $_REQUEST['action'] = 'list_rules';
        } elseif (Tools::isSubmit('update_rule')) {
            $data = $_POST;
            if ($data['name'] != '' && $data['condition'] != '') {
                $data['modified'] = date('Y-m-d H:i:s');
                global $cookie;
                $data['modified_by'] = $cookie->id_employee;
                $rule_info = FgcautoshareruleModel::getInfo($data['id']);
                if ($data['autoshare_ruletype_id'] == 3 && count(explode(",", $data['condition'])) != 2) {
                    $output = $this->displayError($this->l('Add Unsuccess!'));
                } else {
                    if ($rule_info['autoshare_channel_id'] != $data['autoshare_channel_id'] || $rule_info['autoshare_ruletype_id'] != $data['autoshare_ruletype_id']) {
                        if (!FgcautoshareruleModel::checkExistRuleOfChannel($data['autoshare_channel_id'], $data['autoshare_ruletype_id'])) {
                            FgcautoshareruleModel::update($data);
                            $output = $this->displayConfirmation($this->l('Update success!'));
                        } else {
                            $output = $this->displayError($this->l('Rule exist!'));
                        }
                    } else {
                        FgcautoshareruleModel::update($data);
                        $output = $this->displayConfirmation($this->l('Update success!'));
                    }
                }
            } else {
                $output = $this->displayError($this->l('Update Unsuccess!'));
            }
            $_REQUEST['action'] = 'list_rules';
        } elseif (Tools::isSubmit('delete_rules')) {
            $data = $_POST;
            if (count($data['rule_ids']) > 0) {
                FgcautoshareruleModel::delete($data['rule_ids']);
                $output = $this->displayConfirmation($this->l('Delete success!'));
            } else {
                $output = $this->displayError($this->l('Delete Unsuccess!'));
            }
            $_REQUEST['action'] = 'list_rules';
        } elseif (Tools::isSubmit('process_to_queues')) {
            $data = $_POST;
            if (count($data['requests_ids']) > 0) {
                $requests_ids = $data['requests_ids'];
                $list_request = FgcautosharerequestsModel::getList(null, null, null, $requests_ids);
                $list_channels = FgcautosharechannelsModel::getListForQueue(1);
                if (count($list_request) && count($list_channels)) {
                    $this->processToQueue($list_request, $list_channels);
                    //post to socials
                    $this->proccessPostSocials();
                    //end post
                    $output = $this->displayConfirmation($this->l('Process success!'));
                } else {
                    $output = $this->displayError($this->l('Process Unsuccess!'));
                }
            } else {
                $output = $this->displayError($this->l('Process Unsuccess!'));
            }
        }
        $params = array(
            'link_admin' => $adminLink,
            'link_admin_ajax' => FGCAutoshareHelpers::getHttpHost() . $this->_path . 'ajax.php'
        );
        ob_start();
        if ($output != '') {
            echo $output;
        }
        ?>
        <div>
            <?php
            echo $this->setTemplate(null, '/views/header/default.tpl', $params, null, null);
            if ($_REQUEST['action'] == 'add_channel') {
                $list_channelstype = FgcautosharechanneltypesModel::getList();
                echo $this->setTemplate($list_channelstype, '/views/channels/add.tpl', $params);
            } else if ($_REQUEST['action'] == 'edit_channel' && $_REQUEST['channel_id'] != '') {
                $list_channelstype = FgcautosharechanneltypesModel::getList();
                $channel_id = $_REQUEST['channel_id'];
                $info = FgcautosharechannelsModel::getInfo($channel_id);
                echo $this->setTemplate($list_channelstype, '/views/channels/edit.tpl', $params, 'edit_channel', $info);
            } else if ($_REQUEST['action'] == 'add_rule') {
                $list_rulestype = FgcautoshareruletypesModel::getList();
                $list_channels = FgcautosharechannelsModel::getListForRules(1);
                $params['channels'] = $list_channels;
                echo $this->setTemplate($list_rulestype, '/views/rules/add.tpl', $params, 'add_rule');
            } else if ($_REQUEST['action'] == 'edit_rule' && $_REQUEST['rule_id'] != '') {
                $list_rulestype = FgcautoshareruletypesModel::getList();
                $rule_id = $_REQUEST['rule_id'];
                $info = FgcautoshareruleModel::getInfo($rule_id);
                $list_channels = FgcautosharechannelsModel::getListForRules(1);
                $params['channels'] = $list_channels;
                echo $this->setTemplate($list_rulestype, '/views/rules/edit.tpl', $params, 'edit_rule', $info);
            } else if ($_REQUEST['action'] == 'list_requests') {
                //get link cronjob
                $secure_key = Configuration::get('PS_FGCAUTOSHARE_SECURE_KEY');
                $link_cronjob = FGCAutoshareHelpers::getHttpHost() . $this->_path . 'fgcautoshare_cronjob.php?secure_key=' . $secure_key;
                $params['link_cronjob'] = $link_cronjob;
                //end
                $modulelink = $this->getAdminLink();
                $modulelink.="&action=list_requests";
                $total = FgcautosharerequestsModel::getTotal();
                $page = $_REQUEST['page'];
                $data_lang = $this->getDataLang();
                $per_page = 20;
                $paging = FGCAutoshareHelpers::paging($modulelink, $total, $page, $per_page, $data_lang);
                if ($page == null)
                    $page = 1;
                $page -= 1;
                $start = $page * $per_page;
                $list_channels = FgcautosharerequestsModel::getList($start, $per_page);
                echo $this->setTemplate($list_channels, '/views/requests/list.tpl', $params, 'list', $paging);
            }else if ($_REQUEST['action'] == 'list_queues') {
                $modulelink = $this->getAdminLink();
                $modulelink.="&action=list_queues";
                $total = FgcautosharequeuesModel::getTotal();
                $page = $_REQUEST['page'];
                $data_lang = $this->getDataLang();
                $per_page = 20;
                $paging = FGCAutoshareHelpers::paging($modulelink, $total, $page, $per_page, $data_lang);
                if ($page == null)
                    $page = 1;
                $page -= 1;
                $start = $page * $per_page;
                $list_channels = FgcautosharequeuesModel::getList($start, $per_page);
                echo $this->setTemplate($list_channels, '/views/queues/list.tpl', $params, 'list', $paging);
            }else if ($_REQUEST['action'] == 'list_rules') {
                $modulelink = $this->getAdminLink();
                $modulelink.="&action=list_rules";
                $total = FgcautoshareruleModel::getTotal();
                $page = $_REQUEST['page'];
                $data_lang = $this->getDataLang();
                $per_page = 20;
                $paging = FGCAutoshareHelpers::paging($modulelink, $total, $page, $per_page, $data_lang);
                if ($page == null)
                    $page = 1;
                $page -= 1;
                $start = $page * $per_page;
                $list_channels = FgcautoshareruleModel::getList($start, $per_page);
                echo $this->setTemplate($list_channels, '/views/rules/list.tpl', $params, 'list', $paging);
            } else {
                $modulelink = $this->getAdminLink();
                $modulelink.="&action=list";
                $total = FgcautosharechannelsModel::getTotal();
                $page = $_REQUEST['page'];
                $data_lang = $this->getDataLang();
                $per_page = 20;
                $paging = FGCAutoshareHelpers::paging($modulelink, $total, $page, $per_page, $data_lang);
                if ($page == null)
                    $page = 1;
                $page -= 1;
                $start = $page * $per_page;
                $list_channels = FgcautosharechannelsModel::getList($start, $per_page);
                echo $this->setTemplate($list_channels, '/views/channels/list.tpl', $params, 'list', $paging);
            }
            ?>
        </div>
        <?php
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    public function processForCronjob() {
        $list_request = FgcautosharerequestsModel::getList(null, null, '0', null);
        $list_channels = FgcautosharechannelsModel::getListForQueue(1);
        if (count($list_request) && count($list_channels)) {
            $this->processToQueue($list_request, $list_channels);
            //post to socials
            $this->proccessPostSocials();
            //end post
            echo 'Process success!';
        } else {
            echo 'Process Unsuccess!';
        }
    }

    public function processToQueue($list_request, $list_channels) {
        global $cookie;
        foreach ($list_request as $value_request) {
            foreach ($list_channels as $value_channel) {
                if (FGCAutoshareHelpers::checkRuleOfChannel($value_channel['id'], $value_request) == true) {
                    $data_for_queue = FGCAutoshareHelpers::buildDataForQueue($value_request, $cookie->id_employee, $value_channel['id'], $value_channel['max_chars']);
                    FgcautosharequeuesModel::insert($data_for_queue);
                }
            }
            FgcautosharerequestsModel::update(array('id' => $value_request['id'], 'published' => 1));
        }
        return true;
    }

    public function proccessPostSocials() {
        $list_queues = FgcautosharequeuesModel::getListQueuesToProccess();
        foreach ($list_queues as $row) {
            $queue_id = $row['id'];
            $data_access = json_decode($row['params'], true);
            $content_global = explode('^', $row['fulltext']);
            switch ($row['key_channel']) {
                case 'linkedin':
                    $content = array('comment' => '', 'title' => $content_global[0], 'submitted-url' => $content_global[1], 'submitted-image-url' => $content_global[4], 'description' => $content_global[3]);
                    break;
                case 'twitter':
                    $content = array('status' => $content_global[0] . ' ' . $content_global[4]);
                    break;
                case 'facebook':
                    $content = array(
                        "message" => $content_global[0],
                        "link" => $content_global[1],
                        "picture" => $content_global[4],
                        "name" => $content_global[0],
                        "caption" => $content_global[0],
                        "description" => $content_global[3]
                    );
                    break;
                default:
                    $content = array();
                    break;
            }

            if ($row['params'] != '') {
                $response_error = FGCAutoshareHelperSocials::postToSocials($row['key_channel'], $data_access, $content);
                if ($response_error != 'ok') {
                    FgcautosharequeuesModel::update(array('id' => $queue_id, 'status' => 'error', 'message' => $response_error));
                } else {
                    FgcautosharequeuesModel::update(array('id' => $queue_id, 'status' => 'success'));
                }
            }
        }
    }

    /**
     * hook into backend
     */
    public function hookdisplayBackOfficeHeader() {
        $this->context->controller->addCSS($this->_path . 'css/fgcautoshare.css', 'all');
        $this->context->controller->addCSS($this->_path . 'css/paging.css', 'all');
        $this->context->controller->addJS($this->_path . 'js/fgcautoshare.js', 'all');
    }

    /**
     * get admin module link 
     */
    public function getAdminLink() {
        $link = new Link();
        $result = $link->getAdminLink('AdminModules', true);
        $result.="&configure=fgcautoshare&tab_module=advertising_marketing&module_name=fgcautoshare";
        return $result;
    }

    /**
     * Get product info
     * @param type $productId
     * @return int
     */
    public function getProductInfo($productId) {
        $p = new Product($productId, false, (int) Context::getContext()->language->id);
        $images = $p->getImages((int) $this->context->cookie->id_lang);
        if (isset($images[0]))
            $main_image = $images[0];
        foreach ($images as $k => $image) {
            if ($image['cover']) {
                $main_image = $image;
                break;
            }
        }
        $result = array();
        $result['price'] = round($p->getPrice(), 2);
        $result['link_review'] = $this->context->link->getProductLink($productId, $p->link_rewrite, $p->category);

        if ($main_image['id_image']) {
            $result['link_image'] = $this->context->link->getImageLink($p->link_rewrite, $main_image['id_image'], 'medium_default');
        } else {
            $result['link_image'] = '';
        }
        return $result;
    }

    /**
     * Set template
     * @param type $data
     * @param type $view
     * @param type $params
     * @param type $type
     * @return type
     */
    public function setTemplate($data, $view, $params = null, $action = null, $data_info = null) {
        $data_assign = array(
            'datas' => $data,
            'params' => $params
        );

        if ($action == 'edit_channel') {
            $data_assign['info'] = $data_info;
        } elseif ($action == 'list') {
            $data_assign['paging'] = $data_info;
        } elseif ($action == 'edit_rule') {
            $data_assign['channels'] = $params['channels'];
            $data_assign['info'] = $data_info;
        } elseif ($action == 'add_rule') {
            $data_assign['channels'] = $params['channels'];
        }

        $this->smarty->assign($data_assign);
        return $this->display(dirname(__FILE__), $view);
    }

    /**
     * create tables
     * @return boolean
     */
    public function createTable() {
        TableChannels::initTable();
        TableChanneltypes::initTable();
        TableQueues::initTable();
        TableRequests::initTable();
        TableRuletypes::initTable();
        TableRules::initTable();
        return true;
    }

    /**
     * get data lang
     * @return type
     */
    public function getDataLang() {
        $data_lang = array(
            'First' => $this->l('First'),
            'Last' => $this->l('Last'),
            'Next' => $this->l('Next'),
            'Previous' => $this->l('Previous'),
        );
        return $data_lang;
    }

    /**
     * delete tablse
     * @return boolean
     */
    public function deleteTable() {
        $db = Db::getInstance();
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_channels";
        $db->Execute($query);
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_channeltypes";
        $db->Execute($query);
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_queues";
        $db->Execute($query);
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_requests";
        $db->Execute($query);
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_rules";
        $db->Execute($query);
        $query = "DROP TABLE " . _DB_PREFIX_ . "autoshare_ruletypes";
        $db->Execute($query);
        return true;
    }

}
?>