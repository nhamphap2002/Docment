<?php
/**
 * Test with Mywspack
 * @date 28/11/2012
 */
ini_set('memory_limit','512M');
ini_set('display_errors', true);
/**
 * Load autoload
 */
require_once dirname(__FILE__) . '/MywspackAutoload.php';
/**
 * Mywspack Informations
 */
define('MYWSPACK_WSDL_URL','https://www.debitsuccess.com/datatransfer_mysocialteam/DataTransfer.asmx?wsdl');
define('MYWSPACK_USER_LOGIN','publ');
define('MYWSPACK_USER_PASSWORD','monster');
/**
 * Wsdl instanciation infos
 */
$wsdl = array();
$wsdl[MywspackWsdlClass::WSDL_URL] = MYWSPACK_WSDL_URL;
$wsdl[MywspackWsdlClass::WSDL_CACHE_WSDL] = WSDL_CACHE_NONE;
$wsdl[MywspackWsdlClass::WSDL_TRACE] = true;
if(MYWSPACK_USER_LOGIN !== '')
	$wsdl[MywspackWsdlClass::WSDL_LOGIN] = MYWSPACK_USER_LOGIN;
if(MYWSPACK_USER_PASSWORD !== '')
	$wsdl[MywspackWsdlClass::WSDL_PASSWD] = MYWSPACK_USER_PASSWORD;
// etc....
/**
 * Examples
 */


/*********************************
 * Example for MywspackServicePost
 */

$pay_month = 40;
	$initial_payment = 197;

	$tomorrow = mktime(0,0,0,date("m"),date("d")+2,date("Y"));
  $start_date = date("Y-m-d", $tomorrow);


    
$MywspackServicePost = new MywspackServicePost($wsdl);


$any = new DomDocument('1.0','UTF-8');
$clientlist = $any->createElement('ClientList');
$clientlist->setAttribute('xmlns','http://www.debitsuccess.com/clients');

$client = $any->createElement('Client');

$client->appendChild($any->createElement('FirstName','test001'));
$client->appendChild($any->createElement('Surname','test001'));
$client->appendChild($any->createElement('DOB','1980-12-12'));
$client->appendChild($any->createElement('Gender','M'));
$client->appendChild($any->createElement('CustomerClientNo',rand()));

$phyaddress = $any->createElement('PhysicalAddress');
$phyaddress->appendChild($any->createElement('Street','str01'));
$phyaddress->appendChild($any->createElement('Suburb','str01'));
$phyaddress->appendChild($any->createElement('City','str01'));
$phyaddress->appendChild($any->createElement('Postcode','142536'));
$phyaddress->appendChild($any->createElement('State','ACT'));

$PostalAddress = $any->createElement('PostalAddress');
$PostalAddress->appendChild($any->createElement('Street','str01'));
$PostalAddress->appendChild($any->createElement('Suburb','str01'));
$PostalAddress->appendChild($any->createElement('City','str01'));
$PostalAddress->appendChild($any->createElement('Postcode','142536'));
$PostalAddress->appendChild($any->createElement('State','ACT'));

$WorkPhone =  $any->createElement('WorkPhone');
$WorkPhone->appendChild($any->createElement('STD',2));
$WorkPhone->appendChild($any->createElement('Detail','142536987'));
$WorkPhone->appendChild($any->createElement('ContactName','testname'));

$MobilePhone = $any->createElement('MobilePhone');
$MobilePhone->appendChild($any->createElement('STD',2));
$MobilePhone->appendChild($any->createElement('Detail','142536987'));
$MobilePhone->appendChild($any->createElement('ContactName','testname'));


$AccountList  = $any->createElement('AccountList');

$Account = $any->createElement('Account');
$Account->appendChild($any->createElement('CustomerAccountNo',rand()));
$Account->appendChild($any->createElement('StartDate',$start_date));
$Account->appendChild($any->createElement('TermType','M'));
$Account->appendChild($any->createElement('Term',1));
$Account->appendChild($any->createElement('IsOngoing','true'));
$Account->appendChild($any->createElement('AccountType','STD'));

$PaymentDetails = $any->createElement('PaymentDetails');
$PaymentDetails->appendChild($any->createElement('PaymentMethod','CC'));
$PaymentDetails->appendChild($any->createElement('AccountNo','4444333322221111'));
$PaymentDetails->appendChild($any->createElement('CardType','VI'));
$PaymentDetails->appendChild($any->createElement('CardExpiry','2013-05'));


$InvoiceList = $any->createElement('InvoiceList');
$Invoice1 = $any->createElement('Invoice');
$Invoice1->appendChild($any->createElement('Instalment',$pay_month));
$Invoice1->appendChild($any->createElement('Frequency','MN'));
$Invoice1->appendChild($any->createElement('StartDate',$start_date));

$InvoiceList->appendChild($Invoice1 );

$Invoice11 = $any->createElement('Invoice');
$Invoice11->appendChild($any->createElement('Instalment',$initial_payment));
$Invoice11->appendChild($any->createElement('Frequency','OF'));
$Invoice11->appendChild($any->createElement('StartDate',$start_date));
$InvoiceList->appendChild($Invoice11 );


$Account->appendChild($PaymentDetails);
$Account->appendChild($InvoiceList);

$AccountList->appendChild($Account);

$client->appendChild($phyaddress);
$client->appendChild($PostalAddress);
$client->appendChild($WorkPhone);
$client->appendChild($MobilePhone);
$client->appendChild($AccountList);

$clientlist->appendChild($client);
$any->appendChild($clientlist);
//header('Content-type: text/xml');
 $any->save('hh1.xml');
//die;


 
 $dmo = new DomDocument();
 @$dmo->loadXML($any);
 
     
     
			
$xml = new MywspackTypeClientXML($dmo);
//$xml->setAny($any);

$postdat->customerID ='PUB861156';
$postdat->customerCode='PUB35885';
$postdat->clientXML=$dmo;
$postdat =new MywspackTypePostClientData('PUB861156','PUB35885',$dmo);


// sample call for MywspackServicePost::PostClientData()
if($MywspackServicePost->PostClientData($postdat))
	print_r($MywspackServicePost->getResult());
else{
 echo "<pre>";
	print_r($MywspackServicePost->getLastError());

}