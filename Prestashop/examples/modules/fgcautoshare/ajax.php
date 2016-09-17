<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
require_once(dirname(__FILE__) . '../../../config/config.inc.php');
require_once(dirname(__FILE__) . '../../../init.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'helperajax.php');
require_once(dirname(__FILE__) . DS . 'helpers' . DS . 'helperSocials.php');
$action = Tools::getValue('action', '');
switch ($action) {
    case 'getParams':
        //$helperAjax = new HelperAjax();
        $channel_id = Tools::getValue('channel_id', 0);
        $channel_type_id = Tools::getValue('channel_type_id', 0);
        //http://maychu/2014/dev_addon/prestashop/modules/fgcautoshare/ajax.php?action=getParams&channel_id=1&channel_type_id=1
        HelperAjax::displayContent($smarty, $channel_id, $channel_type_id);
        break;
    case 'authenSocials':
        $channel_type = Tools::getValue('type', '');
        switch ($channel_type) {
            case 'linkedin':
                $data_access = array('li_api_key' => Tools::getValue('li_api_key', ''), 'li_api_secret' => Tools::getValue('li_api_secret', ''), 'li_oauth_token' => Tools::getValue('li_oauth_token', ''), 'li_oauth_token_secret' => Tools::getValue('li_oauth_token_secret', ''));
                break;
            case 'twitter':
                $data_access = array('consumer_key' => Tools::getValue('consumer_key', ''), 'consumer_secret' => Tools::getValue('consumer_secret', ''), 'auth_token' => Tools::getValue('auth_token', ''), 'auth_secret' => Tools::getValue('auth_secret', ''));
                break;
            case 'facebook':
                $data_access = array('li_api_key' => Tools::getValue('li_api_key', ''), 'li_api_secret' => Tools::getValue('li_api_secret', ''), 'li_oauth_token' => Tools::getValue('li_oauth_token', ''), 'li_oauth_token_secret' => Tools::getValue('li_oauth_token_secret', ''));
                break;
            default:
                $data_access = array();
                break;
        }
        $response = FGCAutoshareHelperSocials::oAuthen($channel_type, $data_access);
        print_r($response);
        break;
}


