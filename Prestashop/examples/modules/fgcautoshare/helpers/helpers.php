<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helpers
 *
 * @author User
 */
if (!class_exists('ShorturlHelper')) {
    require_once 'shorturl.php';
}

class FGCAutoshareHelpers {

    /**
     * Paging
     * @param type $link
     * @param type $total_data
     * @param type $page
     * @param type $data_lang
     * @return string
     */
    public static function paging($link, $total_data, $page, $per_page, $data_lang) {
        $modulelink = $link;
        $total = $total_data;
        $filter = '';
        if ($page == null)
            $page = 1;
        $cur_page = $page;
        $page -= 1;
        $pageView = 5;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;
        /* --------------------------------------------- */
        $count = $total;
        $no_of_paginations = ceil($count / $per_page);

        if ($cur_page >= $pageView) {
            $start_loop = $cur_page - 2;
            if ($no_of_paginations > $cur_page + 2)
                $end_loop = $cur_page + 2;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 4) {
                $start_loop = $no_of_paginations - 4;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > $pageView)
                $end_loop = $pageView;
            else
                $end_loop = $no_of_paginations;
        }

        $paging = "<div class='pagination'><ul>";

        // FOR ENABLING THE FIRST BUTTON
        if ($first_btn && $cur_page > 1) {
            $paging .= "<li class='active'><a href='" . $modulelink . $filter . "&page=1'>" . $data_lang['First'] . "</a></li>";
        } else if ($first_btn) {
            $paging .= "<li  class='inactive'><a href='" . $modulelink . $filter . "&page=1'>" . $data_lang['First'] . "</a></li>";
        }

        // FOR ENABLING THE PREVIOUS BUTTON
        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $paging .= "<li class='active'><a href='" . $modulelink . $filter . "&page=$pre'>" . $data_lang['Previous'] . "</a></li>";
        } else if ($previous_btn) {
            $paging .= "<li class='inactive'><a href='" . $modulelink . $filter . "&page=$cur_page'>" . $data_lang['Previous'] . "</a></li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {

            if ($cur_page == $i)
                $paging .= "<li style='color:#fff;background-color:#006699;' class='active'><a href='" . $modulelink . $filter . "&page=$i'>$i</a></li>";
            else
                $paging .= "<li class='active'><a href='" . $modulelink . $filter . "&page=$i'>$i</a></li>";
        }

        // TO ENABLE THE NEXT BUTTON
        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $paging .= "<li class='active'><a href='" . $modulelink . $filter . "&page=$nex'>" . $data_lang['Next'] . "</a></li>";
        } else if ($next_btn) {
            $paging .= "<li class='inactive'><a href='" . $modulelink . $filter . "&page=$cur_page'>" . $data_lang['Next'] . "</a></li>";
        }

        // TO ENABLE THE END BUTTON
        if ($last_btn && $cur_page < $no_of_paginations) {
            $paging .= "<li class='active'><a href='" . $modulelink . $filter . "&page=$no_of_paginations'>" . $data_lang['Last'] . "</a></li>";
        } else if ($last_btn) {
            $paging .= "<li class='inactive'><a href='" . $modulelink . $filter . "&page=$no_of_paginations'>" . $data_lang['Last'] . "</a></li>";
        }
        $paging = $paging . "</ul></div>";
        return $paging;
    }

    /**
     * build data product
     * @param type $full_obj_product
     * @param type $product_info_temp
     * @return boolean
     */
    public static function buildDataProduct($full_obj_product, $product_info_temp) {
        $context = Context::getContext();
        $currency = $context->currency;
        if (empty($full_obj_product))
            return false;
        $obj_product_for_request = array(
            'id' => $full_obj_product->id,
            'name' => $full_obj_product->name[1],
            'description' => $full_obj_product->description[1],
            'description_short' => $full_obj_product->description_short[1],
            'price' => $product_info_temp['price'] . $currency->sign,
            'url' => $product_info_temp['link_review'],
            'link_image' => $product_info_temp['link_image']
        );
        return $obj_product_for_request;
    }

    /**
     * build data request
     * @param type $obj_product
     * @param type $employ_id
     * @return string
     */
    public static function buildDataForRequest($obj_product, $employ_id) {
        $data = array(
            'product_id' => $obj_product['id'],
            'product_name' => $obj_product['name'],
            'published' => 0,
            'url' => $obj_product['url'],
            'product_object' => json_encode($obj_product),
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $employ_id,
            'modified' => date('Y-m-d H:i:s'),
            'modified_by' => $employ_id,
            'order' => FgcautosharerequestsModel::getTotal() + 1,
            'params' => ''
        );
        return $data;
    }

    /**
     * build data queue
     * @param type $obj_request
     * @param type $employ_id
     * @return type
     */
    public static function buildDataForQueue($obj_request, $employ_id, $autoshare_channel_id, $max_chars = null) {
        $shortUrlHelper = ShorturlHelper::getInstance();
        $product_object = json_decode($obj_request['product_object']);
        $data = array(
            'product_id' => $obj_request['product_id'],
            'autoshare_channel_id' => $autoshare_channel_id,
            'post_date' => '',
            'status' => 'approve',
            'result_msg' => '',
            'message' => '',
            'url' => $shortUrlHelper->getShortUrl($obj_request['url']),
            'org_url' => $obj_request['url'],
            'title' => $obj_request['product_name'],
            'fulltext' => pSQL(self::buildFulltextForQueue($product_object, $max_chars)),
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $employ_id,
            'modified' => date('Y-m-d H:i:s'),
            'modified_by' => $employ_id,
            'order' => FgcautosharequeuesModel::getTotal() + 1,
            'params' => ''
        );

        return $data;
    }

    /**
     * build fulltext
     * @param type $arr_product
     * @param type $max_chars
     * @return string
     */
    public static function buildFulltextForQueue($obj_product, $max_chars, $option = array('price' => true, 'image' => true)) {
        $shortUrlHelper = ShorturlHelper::getInstance();
        if ($obj_product == '' || $obj_product == null || $max_chars == 0) {
            return '';
        }
        $fulltext = $obj_product->name;
        if (strlen($fulltext) > $max_chars) {
            $fulltext = substr($fulltext, 0, $max_chars);
        } else {
            $char = $max_chars - strlen($fulltext);
            $product_url = $shortUrlHelper->getShortUrl($obj_product->url);
            if ($char >= strlen($product_url)) {
                $fulltext .= "^" . $product_url;
                $char = $max_chars - strlen($fulltext);
                if ($char >= strlen($obj_product->price)) {
                    $fulltext.="^" . $obj_product->price;
                    $char = $max_chars - strlen($fulltext);
                    if ($char >= strlen($obj_product->description_short)) {
                        $fulltext.="^" . $obj_product->description_short;
                    }
                }
            }
        }
        $fulltext.="^" . $obj_product->link_image;
        return $fulltext;
    }

    /**
     * check rule of channel
     * @param type $channel_id
     * @param type $value_request
     * @return boolean
     */
    public static function checkRuleOfChannel($channel_id, $value_request) {
        $arr_rule = FgcautoshareruleModel::getRulesOfChannel($channel_id);
        $product = json_decode($value_request['product_object']);
        $price = substr($product->price, 0, strlen($product->price));
        if (count($arr_rule)) {
            $result = true;
            foreach ($arr_rule as $value) {
                if ($value['expression'] == '<=') {
                    if ($price <= $value['condition']) {
                        $result = true;
                    } else {
                        $result = false;
                        break;
                    }
                } elseif ($value['expression'] == '>=') {
                    if ($price >= $value['condition']) {
                        $result = true;
                    } else {
                        $result = false;
                        break;
                    }
                } elseif ($value['expression'] == 'TO-FROM') {
                    $arr_condition = explode(",", $value['condition']);
                    if ($price >= $arr_condition[0] && $price <= $arr_condition[1]) {
                        $result = true;
                    } else {
                        $result = false;
                        break;
                    }
                } elseif ($value['expression'] == 'IN') {
                    $catOfProduct = FgcautoshareruleModel::getCategoriesOfProduct($product->id);
                    $arr_condition = explode(",", $value['condition']);
                    foreach ($catOfProduct as $cat_p) {
                        if (in_array($cat_p, $arr_condition)) {
                            $result = true;
                        } else {
                            $result = false;
                            break;
                        }
                    }
                } elseif ($value['expression'] == 'NOT-IN') {
                    $catOfProduct = FgcautoshareruleModel::getCategoriesOfProduct($product->id);
                    $arr_condition = explode(",", $value['condition']);
                    foreach ($catOfProduct as $cat_p) {
                        if (!in_array($cat_p, $arr_condition)) {
                            $result = true;
                        } else {
                            $result = false;
                            break;
                        }
                    }
                }
            }
            return $result;
        } else {
            return true;
        }
    }

    /**
     * get current url
     * @return string
     */
    public static function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    /**
     * get domain host
     * @return string
     */
    public static function getHttpHost() {
        $protocol = isset($_SERVER['HTTPS']) ? "https" : "http";
        $host = $protocol . '://' . $_SERVER['HTTP_HOST'];
        return $host;
    }

    public static function buildJsonParams($channel_type_id, $requestData) {
        include_once 'helperajax.php';
        $key_channel = HelperAjax::getKeyChannelType($channel_type_id);
        if (empty($requestData) || !$key_channel)
            return json_encode(array());
        global $ChannelParams;
        $params = array();
        $key_params = isset($ChannelParams[$key_channel]['key_params']) ? $ChannelParams[$key_channel]['key_params'] : array();
        if (!empty($key_params)) {
            foreach ($key_params as $value) {
                $params[$value] = isset($requestData[$value]) ? $requestData[$value] : '';
            }
        }
        return json_encode($params);
    }

}
