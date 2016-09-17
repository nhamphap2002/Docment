<?php

/**
 * Description of request
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class FgcautosharerequestsModel {

    public function __construct() {
        ;
    }

    /**
     * Get list request
     * @return type
     */
    public static function getList($start = null, $limit = null, $published = null, $ids = null) {
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_requests AS ac";
        if ($published != null && $published != '') {
            $sql.=" WHERE ac.published=" . $published." LIMIT 20";
        }
        if ($start >= 0 && $limit > 0) {
            $sql.=" ORDER BY ac.created DESC LIMIT $start, $limit";
        }
        if ($ids != null) {
            $sql.=" WHERE ac.id IN (" . @implode(",", $ids) . ")";
        }

        if ($items = Db::getInstance()->executeS($sql)) {
            return $items;
        } else {
            return array();
        }
    }

    /**
     * Get productid by requestid
     * @param type $request_ids
     * @return type
     */
    public static function getProductIdByRequestId($request_ids) {
        $sql = "SELECT ac.product_id FROM " . _DB_PREFIX_ . "autoshare_requests AS ac";
        if ($request_ids != null) {
            $sql.=" WHERE ac.id IN (" . @implode(",", $request_ids) . ")";
        }
        if ($items = Db::getInstance()->executeS($sql)) {
            $arr = array();
            foreach ($items as $value) {
                $arr[] = $value['product_id'];
            }
            return $arr;
        } else {
            return array();
        }
    }

    /**
     * get total request
     * @return int
     */
    public static function getTotal() {
        $sql = "SELECT COUNT(ac.id) AS total FROM " . _DB_PREFIX_ . "autoshare_requests AS ac";

        $value = Db::getInstance()->getValue($sql);
        if (isset($value) && $value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    /**
     * Get info a request
     * @param type $id
     * @return null
     */
    public static function getInfo($id) {
        $sql = "SELECT ac.* FROM " . _DB_PREFIX_ . "autoshare_requests AS ac WHERE ac.id = '$id'";
        if ($row = Db::getInstance()->getRow($sql)) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * check exist request
     * @param type $product_id
     * @return int
     */
    public static function isExists($product_id) {
        $sql = "SELECT ac.id FROM " . _DB_PREFIX_ . "autoshare_requests AS ac WHERE ac.product_id = '$product_id'";
        $value = Db::getInstance()->getValue($sql);
        if (isset($value) && $value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    /**
     * Insert a request
     * @param type $data
     */
    public static function insert($data) {
        $field = '';
        $values = '';
        foreach ($data as $k => $v) {
            $field.='`' . $k . '`,';
            $values.="'" . pSQL($v) . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $values = substr($values, 0, strlen($values) - 1);
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'autoshare_requests` (' . $field . ')
			VALUES(' . $values . ')';

        if (Db::getInstance()->execute($sql))
            return Db::getInstance()->Insert_ID();

        return false;
    }

    /**
     * update request
     * @param type $data
     * @return boolean
     */
    public static function update($data) {
        $field = '';
        foreach ($data as $k => $v) {
            $field.="`" . $k . "`='" . $v . "',";
        }
        $field = substr($field, 0, strlen($field) - 1);
        $sql = "UPDATE `" . _DB_PREFIX_ . "autoshare_requests` SET " . $field;
        $sql.=" WHERE `id`='" . $data['id'] . "'";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    /**
     * Delete a request
     * @param type $id
     */
    public static function delete($ids) {
        if (!is_array($ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_requests WHERE id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    /**
     * Delete a request by product
     * @param type $id
     */
    public static function deleteByProductIds($ids) {
        if (!is_array($ids)) {
            return false;
        }

        $sql = "DELETE FROM " . _DB_PREFIX_ . "autoshare_requests WHERE product_id IN(" . @implode(",", $ids) . ")";

        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

}
