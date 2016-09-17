<?php

/**
 * Description of channels
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class FgcautosharequeuesModel {

    public function __construct() {
        ;
    }

    public static function getList($start = null, $limit = null, $published = null, $ids = null) {
        $sql = "SELECT ac.*,c.name AS channel_name FROM " . _DB_PREFIX_ . "autoshare_queues AS ac JOIN "._DB_PREFIX_."autoshare_channels AS c ON ac.autoshare_channel_id=c.id";
        if ($start >= 0 && $limit > 0) {
            $sql.=" ORDER BY ac.created DESC LIMIT $start, $limit";
        }
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }
    
    public static function getListQueuesToProccess($start = null, $limit = null) {
        $sql = "SELECT q.id, q.status, c.params, q.fulltext, ct.key_channel 
                FROM  "._DB_PREFIX_."autoshare_channels AS c
                JOIN " . _DB_PREFIX_ . "autoshare_queues AS q ON q.autoshare_channel_id=c.id
                JOIN "._DB_PREFIX_."autoshare_channeltypes AS ct ON c.autoshare_channeltype_id=ct.id
                    WHERE q.status = 'approve' AND c.status = 'verified'";
        if ($start >= 0 && $limit > 0) {
            $sql.=" ORDER BY ac.created DESC LIMIT $start, $limit";
        }
        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * get total
     * @return int
     */
    public static function getTotal() {
        $sql = "SELECT COUNT(ac.id) AS total FROM " . _DB_PREFIX_ . "autoshare_queues AS ac";

        $value = Db::getInstance()->getValue($sql);
        if (isset($value) && $value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    /**
     * Insert a channel
     * @param type $data
     */
    public static function insert($data) {
        unset($data['add_new_channel']);
        unset($data['tab']);
        $field = '';
        $values = '';
        foreach ($data as $k => $v) {
            $field.='`' . $k . '`,';
            $values.="'" . $v . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $values = substr($values, 0, strlen($values) - 1);
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'autoshare_queues` (' . $field . ')
			VALUES(' . $values . ')';

        if (Db::getInstance()->execute($sql))
            return Db::getInstance()->Insert_ID();

        return false;
    }

    public static function update($data) {
        unset($data['update_channel']);
        unset($data['tab']);
        $field = '';
        foreach ($data as $k => $v) {
            $field.="`" . $k . "`='" . $v . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $sql = "UPDATE `" . _DB_PREFIX_ . "autoshare_queues` SET " . $field;
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

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_queues WHERE id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    public static function deleteByProduct($product_ids) {
        if (!is_array($product_ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_queues WHERE product_id IN(" . @implode(",", $product_ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    public static function deleteByChannelId($channel_ids) {
        if (!is_array($product_ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_queues WHERE autoshare_channel_id IN(" . @implode(",", $channel_ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

}
