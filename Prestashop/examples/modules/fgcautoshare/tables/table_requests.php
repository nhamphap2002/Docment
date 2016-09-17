<?php

/**
 * Description of table_requests
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableRequests {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_requests` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `product_id` int(11) DEFAULT NULL,
                                `product_name` varchar(255) DEFAULT NULL,
                                `published` tinyint(4) DEFAULT NULL,
                                `url` varchar(500) DEFAULT NULL,
                                `product_object` text,
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
