<?php

/**
 * Description of table_channeltypes
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class TableChanneltypes {

    public function __construct() {
        ;
    }

    /**
     * Init table
     * @return boolean
     */
    public static function initTable() {
        $db = Db::getInstance();
        $query = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "autoshare_channeltypes` (
                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `name` varchar(100) DEFAULT NULL,
                                `description` varchar(255) DEFAULT NULL,
                                `max_chars` int(4) DEFAULT NULL,
                                PRIMARY KEY (`id`)
				) ENGINE=" . (defined(_MYSQL_ENGINE_) ? _MYSQL_ENGINE : "MyISAM") . " DEFAULT CHARSET=utf8;";
        $query.="INSERT INTO `" . _DB_PREFIX_ . "autoshare_channeltypes` (`id`, `name`, `description`, `max_chars`) VALUES
(1, 'Facebook', 'Facebook', 320),
(2, 'Twitter', 'Twitter', 140),
(3, 'Google+', 'Google+', 320),
(4, 'LinkedIn', 'LinkedIn', 200);";
        $db->Execute($query);

        return true;
    }

}
