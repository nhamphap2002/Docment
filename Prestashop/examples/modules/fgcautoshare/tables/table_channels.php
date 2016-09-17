<?php

/**
 * Description of table_channels
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableChannels {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_channels` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `autoshare_channeltype_id` int(11) DEFAULT NULL,
                                `name` varchar(100) DEFAULT NULL,
                                `description` varchar(255) DEFAULT NULL,
                                `media_mode` varchar(100) DEFAULT NULL COMMENT 'message,attachment,both',
                                `status` varchar(100) DEFAULT NULL COMMENT 'verified,not_verified,error',
                                `error` varchar(500) DEFAULT NULL,
                                `order` int(11) DEFAULT NULL,
                                `params` text,
                                `published` tinyint(4) DEFAULT NULL,
                                `auto_publish` tinyint(4) DEFAULT NULL,
                                `created` datetime DEFAULT NULL,
                                `created_by` int(11) DEFAULT NULL,
                                `modified` datetime DEFAULT NULL,
                                `modified_by` int(11) DEFAULT NULL,
                                PRIMARY KEY (`id`)
				) ENGINE=" . (defined(_MYSQL_ENGINE_) ? _MYSQL_ENGINE : "MyISAM") . " DEFAULT CHARSET=utf8";
        $db->Execute($query);

        return true;
    }

}
