<?php
if (!defined('_PS_VERSION_'))
    exit;

class evaluationAsking extends Module {

    public function __construct() {
        $this->name = 'evaluationasking';
        $this->tab = 'advertising_marketing';
        $this->version = '1.2';
        $this->author = 'FGCTechlution';
        $this->need_instance = 0;
        $this->module_key = "ce5e3477eeb1ed3f98e266bff2a04591";
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

        parent::__construct();
        $this->displayName = $this->l('Customer follow-up for evaluation');
        $this->description = $this->l('Follow-up with your customers to give an evaluation with daily customized e-mails.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete all settings and your logs?');
    }

    public function install() {
        $this->_clearCache('evaluationasking.tpl');
        Configuration::updateValue('PS_EVALUATIONASKING_SECURE_KEY', strtoupper(Tools::passwdGen(16)));
        return (parent::install() && $this->registerHook('header') && $this->registerHook('productFooter') && $this->createTable() && $this->registerHook('actionAuthentication')
                );
    }

    public function uninstall() {
        $this->_clearCache('evaluationasking.tpl');
        Configuration::deleteByName('PS_EVALUATIONASKING_SECURE_KEY');
        return (parent::uninstall() && $this->deleteTable());
    }

    public function getContent() {
        $output = '';
        if (Tools::isSubmit('update_config_api')) {
            $this->_putMailFileContents();
            $output = $this->displayConfirmation($this->l('Settings updated'));
        }
        $protocol = isset($_SERVER['HTTPS']) ? "https" : "http";
        $secure_key = Configuration::get('PS_EVALUATIONASKING_SECURE_KEY');
        $secure_key = '&secure_key=' . $secure_key;
        $host = $protocol . '://' . $_SERVER['HTTP_HOST'];
        ob_start();
        if ($output != '') {
            echo $output;
        }
        ?>
        <script type="text/javascript" src="<?php echo $host . __PS_BASE_URI__; ?>modules/evaluationasking/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                tinymce.init({
                    selector: "textarea.rte",
                    theme: "modern",
                    width: 750,
                    height: 300,
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    content_css: "css/content.css",
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons",
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ]
                });
            });
        </script>
        <div style="margin-top: 10px;">
            <fieldset>
                <legend><?php echo $this->l('Url for cronjob'); ?></legend>
                <div>
                    <b><?php echo $this->l('Cronjob1'); ?>: </b><?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->_path . 'evaluationasking_cronjob.php?date_time=4&type=step1' . $secure_key; ?>
                </div><br/>
                <div>
                    <b><?php echo $this->l('Cronjob2'); ?>: </b><?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->_path . 'evaluationasking_cronjob.php?date_time=5&type=step2' . $secure_key; ?>
                </div><br/>
                <div>
                    <b><?php echo $this->l('Cronjob3'); ?>: </b><?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->_path . 'evaluationasking_cronjob.php?date_time=6&type=step3' . $secure_key; ?>
                </div><br/>
                <div>
                    <b><?php echo $this->l('Cronjob4'); ?>: </b><?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $this->_path . 'evaluationasking_cronjob.php?date_time=7&type=step4' . $secure_key; ?>
                </div>
            </fieldset><br/>
            <fieldset>
                <legend><?php echo $this->l('Email creation interface'); ?></legend>
                <form method="post" action="">
                    <div>
                        <b><?php echo $this->l('Content email'); ?>: </b><br/>
                        <textarea class="rte" cols="150" rows="15" name="body_mail_en"><?php echo stripslashes($this->_getMailFileContents()); ?></textarea>
                    </div><br/>
                    <input type="submit" class="button" value="Save" name="update_config_api"/>
                </form>
            </fieldset>

        </div>

        <?php
        $contents = ob_get_contents();
        ob_end_clean();

        return $contents;
    }

    public function hookDisplayHeader() {
        $this->context->controller->addCSS($this->_path . 'css/evaluationasking.css', 'all');
        $this->context->controller->addJS($this->_path . 'js/evaluationasking.js', 'all');
    }

    public function hookactionAuthentication($params) {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['url_review']) && $_SESSION['url_review'] != '') {
            $url_review = $_SESSION['url_review'];
            header("Location:$url_review");
            unset($_SESSION['url_review']);
            exit;
        }
    }

    /**
     * http://maychu/2013/gaf045/prestashop/index.php?id_product=46&controller=product&enable_review=true&id_customer_review=Nw==
     * @global type $smarty
     * @param type $params
     */
    public function hookProductFooter($params) {
        if (isset($_REQUEST['enable_review']) && $_REQUEST['enable_review'] != '' && $_REQUEST['id_customer_review'] != '') {
           // if ($this->context->customer->isLogged()) {//Bat nguoi dung phai dang nhap
                global $smarty;
                ob_start();
                ?>
                <script type="text/javascript" src="<?php echo $smarty->tpl_vars['base_dir']->value; ?>/js/jquery/jquery-1.7.2.min.js"></script>
                <script type="text/javascript">
                $(document).ready(function() {
                $.fancybox($("#add-review-form"), {});
                });
                </script>
                <style type="text/css">
                    .fancybox-wrap .greyBtnBig{
                        display: none;
                    }
                </style>
                <?php
                $contents = ob_get_contents();
                ob_end_clean();
                echo $contents;
//            } else {
//                if (!isset($_SESSION)) {
//                    session_start();
//                }
//                $_SESSION['url_review'] = $this->curPageURL();
//                Tools::redirect('my-account.php');
//                exit;
//            }
        }
    }

    public function curPageURL() {
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
     * Lay toan bo khach hang co don hang o trang thai shipped
     */
    public function getCustomerShipped() {
        $sql = "SELECT DISTINCT o.`id_customer`,c.email,c.firstname,c.lastname FROM " . _DB_PREFIX_ . "orders AS o JOIN " . _DB_PREFIX_ . "order_state AS os ON o.`current_state`=os.`id_order_state` JOIN " . _DB_PREFIX_ . "customer AS c ON o.`id_customer`=c.`id_customer` WHERE os.shipped='1' AND o.id_lang='" . $this->context->language->id . "' AND UNIX_TIMESTAMP(o.`date_upd`) > UNIX_TIMESTAMP(DATE_ADD( DATE_ADD( NOW() , INTERVAL -3 MONTH ) , INTERVAL -0 DAY ))";
        $items = Db::getInstance()->executeS($sql);
        return $items;
    }

    /**
     * Lay nhung san pham cua 1 khach hang da mua
     * @param type $customerId
     * @param type $dateTime: Bien thoi gian dung de lay nhung don hang da duoc van chuyen sau bao lau
     * @return type
     */
    public function getProductsShippedOfCustomer($customerId, $dateTime) {
        $sql = "SELECT od.product_id FROM " . _DB_PREFIX_ . "orders AS o JOIN " . _DB_PREFIX_ . "order_state AS os ON o.`current_state` = os.`id_order_state` JOIN " . _DB_PREFIX_ . "order_detail AS od ON o.id_order = od.id_order WHERE os.shipped = '1' AND o.date_upd <> '0000-00-00 00:00:00' AND UNIX_TIMESTAMP(TIMESTAMPADD(DAY," . $dateTime . ",`date_upd`)) <= UNIX_TIMESTAMP(NOW()) AND UNIX_TIMESTAMP(`date_upd`) > UNIX_TIMESTAMP(DATE_ADD( DATE_ADD( NOW() , INTERVAL -3 MONTH ) , INTERVAL -0 DAY )) AND o.id_customer = '$customerId' AND o.id_lang = '" . $this->context->language->id . "'";
        $items = Db::getInstance()->executeS($sql);
        return $items;
    }

    /**
     * Kiem tra 1 khach hang da binh luan cho 1 san pham ma ho da mua hay chua
     * @param type $customerId
     * @param type $productId
     * @return boolean
     */
    public function checkIsReviewByCustomer($customerId, $productId) {
        $sql = "SELECT r.id AS object FROM " . _DB_PREFIX_ . "reviewsnippets AS r WHERE r.id_product='$productId' AND r.id_customer='$customerId'";
        $value = Db::getInstance()->getValue($sql);
        if ($value > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Ham phuc vu chay Cronjob
     * Xu ly de gui mail cho khach hang
     * @param type $date_time: Sau khi Shipped bao nhieu ngay
     * @param type $type: Kieu cronjob: 3day, 
     * step1: sau khi shipped 3 ngay
     * step2: sau khi gui mail 1 ko co review thi sau 1 ngay tiep theo gui 1 mail
     * step3: sau khi gui mail 1 ko co review thi sau 2 ngay tiep theo gui 1 mail
     */
    public function processSendEmail($date_time, $type) {
        $customers = $this->getCustomerShipped();
        if (count($customers) > 0) {
            $context = Context::getContext();
            foreach ($customers as $valueCustomer) {
                $customer_id = $valueCustomer['id_customer'];
                $products = $this->getProductsShippedOfCustomer($customer_id, $date_time); //Ke tu ngay Shipped 0 ngay
                if (count($products) > 0) {
                    $arrProductNoReview = array();
                    $is_send = false;
                    foreach ($products as $value) {
                        $product_id = $value['product_id'];
                        if ($this->checkIsReviewByCustomer($customer_id, $product_id) === false) {
                            $num_send_email = $this->getNumSendEmail($product_id, $customer_id);
                            if ($type == 'step1') {
                                if ($num_send_email == 0)
                                    $is_send = true;
                            } elseif ($type == 'step2' || $type == 'step3') {
                                if ($type == 'step2' && $num_send_email == 1) {
                                    $is_send = true;
                                } elseif ($type == 'step3' && $num_send_email == 2) {
                                    $is_send = true;
                                } elseif ($type == 'step4' && $num_send_email == 3) {
                                    $is_send = true;
                                }
                            }
                            if ($is_send == true) {
                                $productInfo = $this->getProductInfo($product_id);
                                $arrProductNoReview[$product_id]['id_product'] = $product_id;
                                $arrProductNoReview[$product_id]['link_image'] = $productInfo['link_image'];
                                $arrProductNoReview[$product_id]['name'] = $productInfo['name'];
                                $arrProductNoReview[$product_id]['link_review'] = $productInfo['link_review'] . '&id_customer_review=' . base64_encode($customer_id);
                            }
                        }
                    }

                    //Send email
                    $subjectEmail = $this->l('Review for products purchased');
                    $contentEmail = $this->createContentEmail($arrProductNoReview);
                    $full_name = $valueCustomer['firstname'] . ' ' . $valueCustomer['lastname'];
                    $full_name = trim($full_name);
                    if (empty($full_name))
                        $full_name = $valueCustomer['email'];
                    $template_vars = array(
                        '{full_name}' => $full_name,
                        '{list_products}' => $contentEmail
                    );
                    if (!empty($contentEmail)) {
                        $sendSuccess = @Mail::Send($context->language->id, 'review', Mail::l($subjectEmail, $context->language->id), $template_vars, $valueCustomer['email'], $full_name, NULL, strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__) . '/mails/');
                    }
                    //end
                    if ($sendSuccess == true) {
                        foreach ($arrProductNoReview as $k => $v) {
                            //Danh dau gui mail cho khach hang tuong ung voi tung san pham
                            if ($type == 'step1') {
                                $this->insertReviewproduct($k, $customer_id);
                            } elseif ($type == 'step2') {
                                $this->updateNumSendEmail($k, $customer_id, 2);
                            } elseif ($type == 'step3') {
                                $this->updateNumSendEmail($k, $customer_id, 3);
                            } elseif ($type == 'step4') {
                                $this->updateNumSendEmail($k, $customer_id, 4);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Lay ten va hinh anh chinh cua san pham
     * @param type $productId
     * @return int
     */
    public function getProductInfo($productId) {
        $p = new Product($productId, false, (int) Context::getContext()->language->id);
        $images = $p->getImages((int) $this->context->cookie->id_lang);
        if (isset($images[0]))
            $main_image = $images[0];
        foreach ($images as $k => $image) {
            if ($image['cover']) {
                $main_image = $image;
                break;
            }
        }
        $result = array();
        $result['name'] = $p->name;
        $result['link_review'] = $this->context->link->getProductLink($productId, $p->link_rewrite, $p->category);
        if (strpos($result['link_review'], '?id_product=')) {
            $result['link_review'].='&enable_review=true';
        } else {
            $result['link_review'].='?enable_review=true';
        }

        if ($main_image['id_image']) {
            $result['link_image'] = $this->context->link->getImageLink($p->link_rewrite, $main_image['id_image'], 'medium_default');
        } else {
            $result['link_image'] = '';
        }
        return $result;
    }

    /**
     * Tao noi dung email
     * @param type $data
     * @return string
     */
    public function createContentEmail($data) {
        if (count($data) > 0) {
            $this->smarty->assign(array(
                'datas' => $data
            ));
            return $this->display(__FILE__, 'list_products.tpl');
        } else {
            return '';
        }
    }

    /**
     * Tao bang khi install
     * @return boolean
     */
    public function createTable() {
        $db = Db::getInstance();
        $query = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'evaluationasking` (
				  `id` int(11) NOT NULL auto_increment,
				  `id_product` int(11) NOT NULL,
				  `id_customer` int(11) NOT NULL,
				  `num_send_email` int(11) NOT NULL,
				  `date_add` timestamp NOT NULL default CURRENT_TIMESTAMP,
				   PRIMARY KEY  (`id`),
				   KEY `id_product` (`id_product`),
				   KEY `id_customer` (`id_customer`)
				) ENGINE=' . (defined(_MYSQL_ENGINE_) ? _MYSQL_ENGINE : "MyISAM") . ' DEFAULT CHARSET=utf8';
        $db->Execute($query);

        return true;
    }

    /**
     * Xoa bang khi Uninstall
     * @return boolean
     */
    public function deleteTable() {
        $db = Db::getInstance();
        $query = "DROP TABLE " . _DB_PREFIX_ . "evaluationasking";
        $db->Execute($query);
        return true;
    }

    /**
     * Danh dau lan gui mail dau tien
     * @param type $id_product
     * @param type $id_customer
     * @return boolean
     */
    public function insertReviewproduct($id_product, $id_customer) {
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'evaluationasking` (`id_product`, `id_customer`, `num_send_email`)
			VALUES(' . (int) $id_product . ', ' . (int) $id_customer . ',1)';

        if (Db::getInstance()->execute($sql))
            return Db::getInstance()->Insert_ID();

        return false;
    }

    /**
     * Lay so lan da gui mail
     * @param type $id_product
     * @param type $id_customer
     * @return int
     */
    public function getNumSendEmail($id_product, $id_customer) {
        $value = Db::getInstance()->getValue("
			SELECT num_send_email
			FROM `" . _DB_PREFIX_ . "evaluationasking`
			WHERE `id_product`='$id_product' AND `id_customer`='$id_customer'");
        if (isset($value) && $value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    /**
     * Cap nhap so lan da gui mail
     * @param type $id_product
     * @param type $id_customer
     * @return boolean
     */
    public function updateNumSendEmail($id_product, $id_customer, $num_send_email) {
        $sql = "UPDATE " . _DB_PREFIX_ . "evaluationasking SET num_send_email='$num_send_email' WHERE id_product='$id_product' AND id_customer='$id_customer'";
        if (Db::getInstance()->execute($sql))
            return true;
        return false;
    }

    public function isProductOfCustomer($customer_id, $product_id) {
        $sql = "SELECT od.product_id FROM " . _DB_PREFIX_ . "orders AS o JOIN " . _DB_PREFIX_ . "order_state AS os ON o.`current_state`=os.`id_order_state` JOIN " . _DB_PREFIX_ . "order_detail AS od ON o.id_order=od.id_order WHERE os.shipped='1' AND o.date_upd <> '0000-00-00 00:00:00' AND o.id_customer='$customer_id' AND o.id_lang='" . $this->context->language->id . "' AND od.product_id='{$product_id}'";
        $items = Db::getInstance()->executeS($sql);
        if (count($items) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function _putMailFileContents() {
        $contents = $_REQUEST['body_mail_en'];
        $file = dirname(__FILE__) . "/mails/en/review.html";
        file_put_contents($file, $contents);
    }

    function _getMailFileContents() {
        $file = dirname(__FILE__) . "/mails/en/review.html";
        $cotents = @file_get_contents($file);
        return $cotents;
    }
	
}
?>