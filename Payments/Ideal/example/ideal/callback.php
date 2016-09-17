<?php

$order_id = 0;
if (!empty($_GET["order_id"])) {
    $order_id = (int) $_GET["order_id"];
}

if (!empty($_GET["amp;order_id"])) {
    $order_id = (int) $_GET["amp;order_id"]; // Buggy redirects
}

if ($order_id == 0) {
    //$this->log->write('TargetPay callback(), no order_id passed');
    die();
}

//$this->load->model('checkout/order');
//$order_info = $this->model_checkout_order->getOrder($order_id);
//
//$targetPayTx = $this->getTxid($order_id);
//if (!$targetPayTx) {
//    $this->log->write('Could not find TargetPay transaction data for order_id=' . $order_id);
//    die();
//}
$rtlo = IDEAL_RTLO; // Default TargetPay
$transactionId = file_get_contents(dirname(__FILE__) . '/tranid.txt'); //Chinh la ma giao dich khi Send va da duoc luu va DB
$targetPay = new TargetPayCore("IDE", $rtlo, "e59dbd219e068daade7139be42c5dfd5", "nl", false);
$targetPay->checkPayment($transactionId);

$order_status_id = 1;
if (!$order_status_id) {
    $order_status_id = 1; // Default to 'pending' after payment
}

if ($targetPay->getPaidStatus() || IDEAL_TEST) {
    file_put_contents(dirname(__FILE__) . '/thanhcong.txt', 'Thanh cong');
    //Cap nhat lai trang thai don hang dang cho xu ly
//    $this->updateTxid($order_id, true);
//    $this->model_checkout_order->confirm($order_id, $order_status_id);
} else {
    file_put_contents(dirname(__FILE__) . '/thatbai.txt', 'That bai !!!!');
    //Cap nhat lai trang thai don hang da huy thanh toan
//    $this->updateTxid($order_id, false, $targetPay->getErrorMessage());
//    $this->model_checkout_order->update($order_id, 7); // Cancelled = 7
}

die("45000");

