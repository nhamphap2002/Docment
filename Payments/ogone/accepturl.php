<?php

include 'sha.class.php';
$arrPost = $_GET;
$str = '';
foreach ($arrPost as $k => $v) {
    $str.=$k . ":" . $v . "\n";
}
file_put_contents(dirname(__FILE__) . "/accept.txt", $str . "\n", FILE_APPEND);

$check = sha($_GET, 'out');
file_put_contents(dirname(__FILE__) . "/sha_client.txt", $check . "\n", FILE_APPEND);

if ($check == $_GET['SHASIGN']) {

    $statusCode = (int) $_GET['STATUS'];

    if ($_GET['NCERROR'] === '0') {
// 
        switch ($statusCode) {
            case 9 : // Capture accepted
                file_put_contents(dirname(__FILE__) . '/st9_new.txt', 'trang thai 9');
                break;
            case 91 : // Capture pending
                file_put_contents(dirname(__FILE__) . '/st91.txt', 'trang thai 91');
                break;
            case 5 : // Authorized
                file_put_contents(dirname(__FILE__) . '/st5.txt', 'trang thai 5');
                break;
            case 51 : // Authorization pending
                file_put_contents(dirname(__FILE__) . '/st51.txt', 'trang thai 51');
                break;
            default:
                file_put_contents(dirname(__FILE__) . '/st_default.txt', 'trang thai st_default');
                break;
        }

//redirect den trang thong bao thanh toan thanh cong
    } else {
        switch ($statusCode) {
            case 0 : // payment entry not completed
            case 1 : // cancelled by user
            case 2 : // not authorized (number of tries exceeds payment retry setting)
// Don't confirm the order!!
// Transaction retry is possible, therefore return to cart.
// Please note that in case of status 2, the transaction has been refused by Ogone.
// This will be visible in the transaction overview in the Ogone management application. 
// If you were to resend the the same transaction details, it would be automatically refused by Ogone, even
// if you entered proper payment details.
// However, opencart 1.5.x generates a new orderID on checkout confirm, so no harm in resubmitting. 
//redirect den trang san pham de mua hang
                break;
            case 52 :
            case 92 :
// In both cases 52 and 92 Ogone recommends not reprocessing the transaction, becos it could result in double payment
// Therefore we are confirming the order.
                file_put_contents(dirname(__FILE__) . '/st_52_92.txt', 'trang thai st_52_92');
//redirect den trang thong bao thanh toan thanh cong
                break;
        }
    }
} else {
    file_put_contents(dirname(__FILE__) . '/verification.txt', 'Xac thuc khong thanh cong!. thanh toan that bai');
}
?>