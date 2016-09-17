<?php

include 'config.php';
include_once 'poli.class.php';
$poli = new POLI();

$ipaddress = $_SERVER["REMOTE_ADDR"];
$token = null; //Make token accessible as null to the whole document.
if (isset($_POST["Token"])) {//If it's in get
    $token = $_POST["Token"]; //Set it
}
if (isset($_GET["token"]) && !isset($_POST["Token"])) {//If it's in get
    $token = $_GET["token"]; //Set it
}

$result = 12345;
$authenticationcode = AUTHEN_CODE;
$merchantcode = MERCHANT_CODE;
$url = "https://merchantapi.apac.paywithpoli.com/MerchantAPIService.svc/Xml/transaction/query";
$paramsXmlBuilder = array(
    'authenticationcode' => $authenticationcode,
    'merchantcode' => $merchantcode,
    'token' => $token,
);
if ($token != null) {
    $xml_builder = $poli->xmlBuilderForCallback($paramsXmlBuilder);
}

$response = $poli->sendRequest($url, $xml_builder);
file_put_contents(dirname(__FILE__) . '/callback.txt', $response . "\n", FILE_APPEND);

$xml = new SimpleXMLElement($response); //Save the response as XML


$xml->registerXPathNamespace('', 'http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.Contracts');
$xml->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.DCO');
$xml->registerXPathNamespace('i', 'http://www.w3.org/2001/XMLSchema-instance');
$orderid = null;
$status = 15;
$order_status = "10";
if ($token) {
    foreach ($xml->xpath('//a:AmountPaid') as $value) {
        echo '<br>Amount Paid: ' . $value;
    }
    foreach ($xml->xpath('//a:PaymentAmount') as $value) {
        echo '<br>Payment Amount: ' . $value;
    }
    foreach ($xml->xpath('//a:CurrencyName') as $value) {
        echo '<br>Currency Name: ' . $value;
    }
    foreach ($xml->xpath('//a:BankReceipt') as $value) {
        echo '<br>Bank Receipt: ' . $value;
    }
    foreach ($xml->xpath('//a:BankReceiptDateTime') as $value) {
        echo '<br>Bank Receipt Date/Time: ' . $value;
    }
    foreach ($xml->xpath('//a:FinancialInstitutionCode') as $value) {
        echo '<br>Financial Institution Code: ' . $value;
    }
    foreach ($xml->xpath('//a:MerchantReference') as $value) {
        echo '<br>Merchant Reference: ' . $value;
        $orderid = $value;
    }
    foreach ($xml->xpath('//a:MerchantDefinedData') as $value) {
        echo '<br>Merchant Defined Data: ' . $value;
        $order_status = $value;
    }
    foreach ($xml->TransactionStatusCode as $value) {
        echo 'Transaction Status Code: ' . $value;
        if ($value == "Completed") {
            file_put_contents(dirname(__FILE__) . '/Completed.txt', $value . "\n", FILE_APPEND);
            $status = $order_status;
        }
        if ($value == "TimedOut") {
            file_put_contents(dirname(__FILE__) . '/TimedOut.txt', $value . "\n", FILE_APPEND);
            $status = "10";
        }
        if ($value == "Failed") {
            file_put_contents(dirname(__FILE__) . '/Failed.txt', $value . "\n", FILE_APPEND);
            $status = "10";
        }
        if ($value == "Cancelled") {
            file_put_contents(dirname(__FILE__) . '/Cancelled.txt', $value . "\n", FILE_APPEND);
            $status = "10";
        }
    }
}