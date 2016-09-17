<?php

/**
 * Description of table_queues
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableQueues {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_queues` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `product_id` int(11) DEFAULT NULL,
                                `autoshare_channel_id` int(11) DEFAULT NULL,
                                `post_date` datetime DEFAULT NULL,
                                `status` varchar(100) DEFAULT NULL COMMENT 'error,success,approve,cronjob,cancel',
                                `result_msg` varchar(255) DEFAULT NULL,
                                `message` varchar(500) DEFAULT NULL,
                                `url` varchar(500) DEFAULT NULL,
                                `org_url` varchar(500) DEFAULT NULL,
                                `title` varchar(255) DEFAULT NULL,
                                `fulltext` text,
                                `created` datetime DEFAULT NULL,
                                `created_by` int(11) DEFAULT NULL,
                                `modified` datetime DEFAULT NULL,
                                `modified_by` int(11) DEFAULT NULL,
                                `order` int(11) DEFAULT NULL,
                                `params` text,
                                PRIMARY KEY (`id`)
				) ENGINE=" . (defined(_MYSQL_ENGINE_) ? _MYSQL_ENGINE : "MyISAM") . " DEFAULT CHARSET=utf8";
        $db->Execute($query);

        return true;
    }

}
