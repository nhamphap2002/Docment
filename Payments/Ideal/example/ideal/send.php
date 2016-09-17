<?php

include_once './config.php';
include_once './targetpay.class.php';
$targetPay = new TargetPayCore("IDE", 94103, "e59dbd219e068daade7139be42c5dfd5", "nl", false);
$payment_type = 'Sale';

//$this->load->model('checkout/order');
//$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

$rtlo = IDEAL_RTLO; // Default TargetPay
$order_info['currency_code'] = 'EUR';
$order_info['total'] = 10;
$order_info['order_id'] = 1;
if ($order_info['currency_code'] != "EUR") {
    $json['error'] = "Invalid currency code " . $order_info['currency_code'];
} else {

    $targetPay = new TargetPayCore("IDE", $rtlo, "e59dbd219e068daade7139be42c5dfd5", "nl", false);
    $targetPay->setAmount(round($order_info['total'] * 100));
    $targetPay->setDescription("Order #" . $order_info['order_id']);
    if (!empty($_REQUEST['bank_id'])) {
        $targetPay->setBankId($_REQUEST['bank_id']);
    }
    $targetPay->setCancelUrl(SITE . 'cart.php');
    $targetPay->setReturnUrl(SITE . 'success.php');
    $targetPay->setReportUrl(SITE . 'callback.php?order_id=' . $order_info['order_id']);

    $bankUrl = $targetPay->startPayment();
    file_put_contents(dirname(__FILE__) . '/tranid.txt', $targetPay->getTransactionId());
//Luu $targetPay->getTransactionId()  vao DB
    //$this->storeTxid($targetPay->getPayMethod(), $targetPay->getTransactionId(), $this->session->data['order_id']);

    if (!$bankUrl) {
        $json['error'] = 'TargetPay start payment failed: ' . $targetPay->getErrorMessage();
    } else {
        $json['success'] = $bankUrl;
    }
}
echo json_encode($json);
