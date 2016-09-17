<?php

/**
 * Description of channels
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class FgcautosharechannelsModel {

    public function __construct() {
        ;
    }

    /**
     * Get list channel
     * @return type
     */
    public static function getList($start, $limit) {
        $sql = "SELECT ac.*,ct.name AS channel_type_name,ct.max_chars  FROM " . _DB_PREFIX_ . "autoshare_channels AS ac JOIN " . _DB_PREFIX_ . "autoshare_channeltypes AS ct ON ac.autoshare_channeltype_id=ct.id";
        $sql.=" ORDER BY ac.created DESC LIMIT $start, $limit";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * Get list channel for queues
     * @param type $published
     *              1: publish; 0: unpublish
     * @return type
     */
    public static function getListForQueue($published) {
        $sql = "SELECT ac.id,ct.max_chars, ac.params, ct.key_channel FROM " . _DB_PREFIX_ . "autoshare_channels AS ac JOIN " . _DB_PREFIX_ . "autoshare_channeltypes AS ct ON ac.autoshare_channeltype_id=ct.id";
        if ($published >= 0) {
            $sql.=" WHERE ac.status='verified' AND ac.published=" . $published;
        }
        $sql.=" ORDER BY ac.created DESC";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * get list channel for rule
     * @param type $published
     * @return type
     */
    public static function getListForRules($published) {
        $sql = "SELECT ac.id,ac.name FROM " . _DB_PREFIX_ . "autoshare_channels AS ac JOIN " . _DB_PREFIX_ . "autoshare_channeltypes AS ct ON ac.autoshare_channeltype_id=ct.id";
        if ($published >= 0) {
            $sql.=" WHERE ac.status='verified' AND ac.published=" . $published;
        }
        $sql.=" ORDER BY ac.created DESC";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    public static function getListChannelByType($type) {
        $sql = "SELECT ac.id,ct.max_chars, ac.params, ct.key_channel FROM " . _DB_PREFIX_ . "autoshare_channels AS ac JOIN " . _DB_PREFIX_ . "autoshare_channeltypes AS ct ON ac.autoshare_channeltype_id=ct.id";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    public static function getTotal() {
        $sql = "SELECT COUNT(ac.id) AS total FROM " . _DB_PREFIX_ . "autoshare_channels AS ac JOIN " . _DB_PREFIX_ . "autoshare_channeltypes AS ct ON ac.autoshare_channeltype_id=ct.id";

        $value = Db::getInstance()->getValue($sql);
        if (isset($value) && $value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    /**
     * Get info a channel
     * @param type $id
     * @return null
     */
    public static function getInfo($id) {
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_channels AS ac WHERE ac.id = '$id'";
        if ($row = Db::getInstance()->getRow($sql)) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * Insert a channel
     * @param type $data
     */
    public static function insert($data) {
        $field = '';
        $values = '';
        $data['order'] = self::getTotal() + 1;
        global $tbl_channels_field;
        foreach ($data as $k => $v) {
            foreach ($tbl_channels_field as $tbl_field) {
                if ($k == $tbl_field) {
                    $field.='`' . $k . '`,';
                    $values.="'" . $v . "',";
                }
            }
        }
        $field = substr($field, 0, strlen($field) - 1);
        $values = substr($values, 0, strlen($values) - 1);
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'autoshare_channels` (' . $field . ')
			VALUES(' . $values . ')';

        if (Db::getInstance()->execute($sql))
            return Db::getInstance()->Insert_ID();

        return false;
    }

    public static function update($data) {
        $field = '';
        global $tbl_channels_field;
        foreach ($data as $k => $v) {
            foreach ($tbl_channels_field as $tbl_field) {
                if ($k == $tbl_field) {
                    $field.="`" . $k . "`='" . $v . "',";
                }
            }
        }
        $field = substr($field, 0, strlen($field) - 1);
        $sql = "UPDATE `" . _DB_PREFIX_ . "autoshare_channels` SET " . $field;
        $sql.=" WHERE `id`='" . $data['id'] . "'";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    /**
     * Delete a channel
     * @param type $id
     */
    public static function delete($ids) {
        if (!is_array($ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_channels WHERE id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

}
