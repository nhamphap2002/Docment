<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperajax
 *
 * @author hoangbien264
 */
class HelperAjax {

    //put your code here
    public static function getParamChannel($channel_id) {
        if (!$channel_id)
            return array();
        $query = "SELECT params FROM " . _DB_PREFIX_ . "autoshare_channels AS ac WHERE ac.id = '" . $channel_id . "'";
        if ($row = Db::getInstance()->getRow($query)) {
            if ($row['params'] != "") {
                return json_decode($row['params']);
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public static function displayContent($smarty, $channel_id, $channel_type_id) {
        if (!$channel_id || !$channel_type_id)
            echo '';
        $params = self::getParamChannel($channel_id);
        $filename = self::getKeyChannelType($channel_type_id);
        $template = dirname(dirname(__FILE__)) . DS . 'views' . DS . 'params' . DS . $filename . '.tpl';
        // echo $template;
        if (file_exists($template)) {
            // echo $template;
            /* @var $smarty Smarty */
            //$smarty->setTemplateDir($template);
            $smarty->assign('params', $params);
            echo $smarty->display($template);
        } else {
            echo '';
        }
    }

    public static function getKeyChannelType($channel_type_id) {
        if (!$channel_type_id)
            return '';
        $query = "SELECT key_channel FROM " . _DB_PREFIX_ . "autoshare_channeltypes AS ac WHERE ac.id = '" . $channel_type_id . "'";
        if ($row = Db::getInstance()->getRow($query)) {
            if ($row['key_channel'] != "") {
                return $row['key_channel'];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

}
