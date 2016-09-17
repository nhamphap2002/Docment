<?php
//start session in all pages
if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
//if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

$PayPalMode 			= 'sandbox'; // sandbox or live
$PayPalApiUsername 		= 'chien.lexuan-facilitator_api1.gmail.com'; //PayPal API Username
$PayPalApiPassword 		= '1363850849'; //Paypal API password
$PayPalApiSignature 	= 'AjL0.ZxxKhEzS2GkWTTDIcCBk6aVAa6UvHYuPYISDL.c58dYpcKNEn5m'; //Paypal API Signature
$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
$PayPalReturnURL 		= 'http://lexuanchien.byethost7.com/paypal-express-checkout/process.php'; //Point to process.php page
$PayPalCancelURL 		= 'http://lexuanchien.byethost7.com/paypal-express-checkout/cancel_url.php'; //Cancel URL if user clicks cancel
?>