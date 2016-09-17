<?php

/**
 * Description of channeltypes
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class FgcautosharechanneltypesModel {

    public function __construct() {
        ;
    }

    /**
     * Get list channeltypes
     * @return type
     */
    public static function getList() {
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_channeltypes AS ac";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * Get info a channeltype
     * @param type $id
     * @return null
     */
    public static function getInfo($id) {
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_channeltypes AS ac WHERE ac.id = `$id`";
        if ($row = Db::getInstance()->getRow($sql)) {
            return $row;
        } else {
            return null;
        }
    }

}
