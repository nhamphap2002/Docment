<?php

class ControllerPaymentNabHostedPage extends Controller {

    public function index() {
        $_SESSION['customer_ip'] = trim($_SERVER['REMOTE_ADDR']);
        $this->language->load('payment/nabhostedpage');

        $data['text_testmode'] = $this->language->get('text_testmode');
        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['testmode'] = $this->config->get('nabhostedpage_test');

        if (!$this->config->get('nabhostedpage_test')) {
            $data['action'] = 'https://transact.nab.com.au/live/hpp/payment';
        } else {
            $data['action'] = 'https://transact.nab.com.au/test/hpp/payment';
        }

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) {
            $data['vendor_name'] = $this->config->get('nabhostedpage_merchantid');
            $data['print_zero_qty'] = 'false';
            $data['receipt_address'] = $order_info['email'];
            $data['payment_reference'] = $this->session->data['order_id'];
            $data['return_link_url'] = $this->url->link('checkout/success');
            $data['reply_link_url'] = $this->url->link('payment/nabhostedpage/callback', '&payment=nabhostedpage&bank_reference=&payment_amount=&payment_number=&payment_reference=');
            $data['payment_alert'] = '';
            $data['return_link_text'] = $this->language->get('text_return_home_page');
            $data['Customer_Name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8') . ' ' . html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
            $data['Customer_Company_Name'] = $order_info['payment_company'];
            $data['Customer_Street'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
            $data['Customer_City'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
            $data['Customer_State'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
            $data['Customer_Post_Code'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
            $data['Customer_Country'] = $order_info['payment_country'];
            $data['Customer_Phone'] = $order_info['telephone'];


            $data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

            $data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {
                $data['products'][] = array(
                    'name' => htmlspecialchars($product['name']),
                    'price' => $this->currency->format($product['price'], $order_info['currency_code'], false, false),
                    'quantity' => $product['quantity']
                );
            }

            $data['discount_amount_cart'] = 0;
            $total = $this->currency->format($order_info['total'] - $this->cart->getSubTotal(), $order_info['currency_code'], false, false);

            if ($total > 0) {
                $data['products'][] = array(
                    'name' => $this->language->get('text_total'),
                    'price' => $total,
                    'quantity' => 1
                );
            } else {
                $data['discount_amount_cart'] -= $total;
                $data['Discount'] = '1,-' . $data['discount_amount_cart'];
            }
            $data['information_fields'] = 'Customer_Name,Customer_Company_Name,Customer_Street,Customer_City,Customer_State,Customer_Post_Code,Customer_Country,Customer_Phone';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/nabhostedpage.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/payment/nabhostedpage.tpl', $data);
            } else {
                return $this->load->view('default/template/payment/nabhostedpage.tpl', $data);
            }
        }
    }

    public function callback() {
        if (isset($_REQUEST['payment_reference'])) {
            $order_id = $_REQUEST['payment_reference'];
        } else {
            $order_id = 0;
        }
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
        if ($this->config->get('nabhostedpage_log') == 1) {
            file_put_contents(DIR_LOGS . '/nabhostedpage.log', "\n ===" . date('Y-m-d H:i:s') . "== \n" . "Response from NAB \n" . json_encode($_REQUEST) . "\n Order info \n" . json_encode($order_info) . "\n", FILE_APPEND);
        }
        if ($order_info) {
            $customer_ip = $_SESSION['customer_ip'];
            if ($_SERVER['REMOTE_ADDR'] != $customer_ip || empty($customer_ip) && $_REQUEST['payment'] == 'nabhostedpage' && $_REQUEST['payment_amount'] == $order_info['total']) {
                $this->load->language('payment/nabhostedpage');
                $this->load->model('checkout/order');
                $order_status_id = $this->config->get('nabhostedpage_completed_status_id');
                $comment = "Payment successful. <br />Transaction ID: " . $_REQUEST['bank_reference'] . "<br />NAB Transact Status: Approved";
                $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $comment, 1);
            }
        }
    }

}
