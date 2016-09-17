<?php

/**
 * Description of table_ruletypes
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableRuletypes {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_ruletypes` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `name` varchar(64) DEFAULT NULL,
                                    `expression` varchar(50) DEFAULT NULL,
                                    PRIMARY KEY (`id`)
				) ENGINE=" . (defined(_MYSQL_ENGINE_) ? _MYSQL_ENGINE : "MyISAM") . " DEFAULT CHARSET=utf8;";
        $query.="INSERT INTO `" . _DB_PREFIX_ . "autoshare_ruletypes` (`id`, `name`, `expression`) VALUES
(1, 'price', '>='),
(2, 'price', '<='),
(3, 'price', 'TO-FROM'),
(4, 'categories', 'IN'),
(5, 'categories', 'NOT-IN');";
        $db->Execute($query);

        return true;
    }

}
