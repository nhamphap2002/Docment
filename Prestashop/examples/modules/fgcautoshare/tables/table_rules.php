<?php

/**
 * Description of table_rules
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableRules {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_rules` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(255) DEFAULT NULL,
                                    `autoshare_ruletype_id` int(11) DEFAULT NULL,
                                    `autoshare_channel_id` int(11) DEFAULT NULL,
                                    `condition` varchar(255) DEFAULT NULL,
                                    `published` tinyint(4) DEFAULT NULL,
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
