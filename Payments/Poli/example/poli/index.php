<?php

include_once 'config.php';
include_once 'poli.class.php';
$poli = new POLI();
$site = SITE;
$poli_logo = $site . 'image/poli.gif'; //Logo cua phuong thuc thanh toan Poli
$description = 'Mô tả '; //lay tu cau hinh
$transaction_id = 1; //chinh la ID don hang
$return_url = SITE . 'success.php';
$cancel_url = SITE . 'cancel.php';
$status_url = SITE . 'callback.php';
$language = 'AU';
$logo = $site . 'image/poli2.png'; //lay tu cau hinh
$pay_from_email = 'dev.lexuanchien@gmail.com'; //lay tu thong tin don hang
$firstname = 'le xuan'; //lay tu thong tin don hang
$lastname = 'chien'; //lay tu thong tin don hang
$address = 'dia chi 1'; //lay tu thong tin don hang
$address2 = 'dia chi 2'; //lay tu thong tin don hang
$phone_number = '0986478150'; //lay tu thong tin don hang
$postal_code = '1234'; //lay tu thong tin don hang
$city = 'vinh'; //lay tu thong tin don hang
$state = 'Nghe An'; //lay tu thong tin don hang
$country = 'Viet Nam'; //lay tu thong tin don hang
$amount = 345; //lay tu thong tin don hang
$currency = 'AUD'; //lay tu thong tin don hang
$detail1_text = '1 x may tinh,2 x may in'; //thong tin san pham cach nhau dau phay
$order_id = 1; //lay tu thong tin don hang
$platform = '31974336';
$button_confirm = 'Submit';
$merchantcode = MERCHANT_CODE; //lay tu cau hinh
$authenticationcode = AUTHEN_CODE; //lay tu cau hinh
//$merchantref = $this->config->get('poli_merchantref');
//$merchantrefformat = $this->config->get('poli_merchantrefformat');;
$errorurl = '';
$merchantrefnumber = time();
$pcurrency = 'AUD'; //lay tu config
$amount = number_format(59, 2, '.', ''); //lay tu don hang
$merchantdata = 10; //lay tu don hang
$datetime = date('Y-m-d') . 'T' . date('H:i:s'); /**/
$actuallink = '';
$baselink = SITE . "cancel.php";
$currency = 'AUD'; //lay tu dong hang
$order_status = 'pending'; //lay tu config
$success = SITE . "success.php"; //$this->data['return_url'];
$cancel = SITE . "un_success.php";
$nudge = SITE . "callback.php";
$ipaddress = $_SERVER["REMOTE_ADDR"];
$redirect_url = '';
$url = "https://merchantapi.apac.paywithpoli.com/MerchantAPIService.svc/Xml/transaction/initiate"; //Set url to the initiate endpoint. Check carefully.

$paramsXmlBuilder = array(
    'authenticationcode' => $authenticationcode,
    'amount' => $amount,
    'pcurrency' => $pcurrency,
    'actuallink' => $actuallink,
    'merchantcode' => $merchantcode,
    'order_status' => $order_status,
    'datetime' => $datetime,
    'baselink' => $baselink,
    'merchantdata' => $merchantdata,
    'nudge' => $nudge,
    'success' => $success,
    'cancel' => $cancel,
    'ipaddress' => $ipaddress
);
$xml_builder = $poli->xmlBuilderForRedirect($paramsXmlBuilder);
$response = $poli->sendRequest($url, $xml_builder);
$xml = new SimpleXMLElement($response); //Save the response as XML

$xml->registerXPathNamespace('', 'http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.Contracts');
$xml->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.DCO');
$xml->registerXPathNamespace('i', 'http://www.w3.org/2001/XMLSchema-instance');

foreach ($xml->xpath('//a:NavigateURL') as $value) {
    $redirect_url = $value;
}
foreach ($xml->xpath('///a:Code') as $value) {
    echo 'Error code: ' . $value;
}
foreach ($xml->xpath('////a:Message') as $value) {
    echo '<br>Error message: ' . $value;
    exit();
}
$action = SITE . "confirm.php?redirect_url=" . $redirect_url;
$paramsFormBuilder = array(
    'poli_logo' => $poli_logo,
    'action' => $action,
    'description' => $description,
    'transaction_id' => $transaction_id,
    'return_url' => $return_url,
    'cancel_url' => $cancel_url,
    'status_url' => $status_url,
    'language' => $language,
    'logo' => $logo,
    'pay_from_email' => $pay_from_email,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'address' => $address,
    'address2' => $address2,
    'phone_number' => $phone_number,
    'postal_code' => $postal_code,
    'city' => $city,
    'state' => $state,
    'country' => $country,
    'amount' => $amount,
    'currency' => $currency,
    'detail1_text' => $detail1_text,
    'order_id' => $order_id,
    'platform' => $platform,
    'button_confirm' => $button_confirm,
    'merchantcode' => $merchantcode,
);
echo $poli->formBuilder($paramsFormBuilder);
?>

