<?php

/**
 * Description of channels
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class FgcautoshareruleModel {

    public function __construct() {
        ;
    }

    /**
     * Get list channel
     * @return type
     */
    public static function getList($start, $limit) {
        $sql = "SELECT ac.*,ct.name AS rule_type_name,c.name AS channel_name,ct.expression  FROM " . _DB_PREFIX_ . "autoshare_rules AS ac JOIN " . _DB_PREFIX_ . "autoshare_ruletypes AS ct ON ac.autoshare_ruletype_id=ct.id JOIN " . _DB_PREFIX_ . "autoshare_channels AS c ON ac.autoshare_channel_id=c.id";
        $sql.=" ORDER BY ac.created DESC LIMIT $start, $limit";
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    public static function getTotal() {
        $sql = "SELECT COUNT(ac.id) AS total FROM " . _DB_PREFIX_ . "autoshare_rules AS ac JOIN " . _DB_PREFIX_ . "autoshare_ruletypes AS ct ON ac.autoshare_ruletype_id=ct.id";

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
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_rules AS ac WHERE ac.id = '$id'";
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
        unset($data['add_new_rule']);
        unset($data['tab']);
        $field = '';
        $values = '';
        foreach ($data as $k => $v) {
            $field.='`' . $k . '`,';
            $values.="'" . $v . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $values = substr($values, 0, strlen($values) - 1);
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'autoshare_rules` (' . $field . ')
			VALUES(' . $values . ')';

        if (Db::getInstance()->execute($sql))
            return Db::getInstance()->Insert_ID();

        return false;
    }

    public static function update($data) {
        unset($data['update_rule']);
        unset($data['tab']);
        $field = '';
        foreach ($data as $k => $v) {
            $field.="`" . $k . "`='" . $v . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $sql = "UPDATE `" . _DB_PREFIX_ . "autoshare_rules` SET " . $field;
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

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_rules WHERE id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    /**
     * delete rules by channel
     * @param type $ids
     * @return boolean
     */
    public static function deleteByChannelId($ids) {
        if (!is_array($ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_rules WHERE autoshare_channel_id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    /**
     * Get rules of a channel
     * @param type $channel_id
     * @return type
     */
    public static function getRulesOfChannel($channel_id) {
        $sql = "SELECT ac.condition,ct.expression FROM " . _DB_PREFIX_ . "autoshare_rules AS ac JOIN " . _DB_PREFIX_ . "autoshare_ruletypes AS ct ON ac.autoshare_ruletype_id=ct.id JOIN " . _DB_PREFIX_ . "autoshare_channels AS c ON ac.autoshare_channel_id=c.id WHERE c.id='$channel_id'";

        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * check rule type of channel
     * @param type $channel_id
     * @param type $rule_type
     * @return boolean
     */
    public static function checkExistRuleOfChannel($channel_id, $rule_type) {
        $sql = "SELECT COUNT(ac.id) AS total FROM " . _DB_PREFIX_ . "autoshare_rules AS ac JOIN " . _DB_PREFIX_ . "autoshare_ruletypes AS ct ON ac.autoshare_ruletype_id=ct.id JOIN " . _DB_PREFIX_ . "autoshare_channels AS c ON ac.autoshare_channel_id=c.id WHERE ac.autoshare_channel_id='$channel_id' AND ac.autoshare_ruletype_id='$rule_type'";

        $value = Db::getInstance()->getValue($sql);
        if (isset($value) && $value > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get categories of product
     * @param type $product_id
     * @return type
     */
    public static function getCategoriesOfProduct($product_id) {
        $sql = "SELECT c.id_category FROM " . _DB_PREFIX_ . "category_product AS c WHERE c.id_product='$product_id'";

        if ($items = Db::getInstance()->executeS($sql)) {
            $arr_temp = array();
            foreach ($items as $value) {
                $arr_temp[] = $value['id_category'];
            }
            return $arr_temp;
        } else {
            return array();
        }
    }

}
