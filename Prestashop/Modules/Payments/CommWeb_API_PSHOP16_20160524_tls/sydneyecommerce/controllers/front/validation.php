<?php

/*

* 2007-2012 PrestaShop

*

* NOTICE OF LICENSE

*

* This source file is subject to the Academic Free License (AFL 3.0)

* that is bundled with this package in the file LICENSE.txt.

* It is also available through the world-wide-web at this URL:

* http://opensource.org/licenses/afl-3.0.php

* If you did not receive a copy of the license and are unable to

* obtain it through the world-wide-web, please send an email

* to license@prestashop.com so we can send you a copy immediately.

*

* DISCLAIMER

*

* Do not edit or add to this file if you wish to upgrade PrestaShop to newer

* versions in the future. If you wish to customize PrestaShop for your

* needs please refer to http://www.prestashop.com for more information.

*

*  @author PrestaShop SA <contact@prestashop.com>

*  @copyright  2007-2012 PrestaShop SA

*  @version  Release: $Revision: 15094 $

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)

*  International Registered Trademark & Property of PrestaShop SA

*/



/**

 * @since 1.5.0

 */

class SydneyecommerceValidationModuleFrontController extends ModuleFrontController
{
	/**

	 * @see FrontController::postProcess()

	 */

	public function postProcess()
	{
		$cart = $this->context->cart;

		if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
		{
			$json['error'] = 'Please login or input your address to continue';
			echo json_encode($json);exit;
		}

		// Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
		$authorized = false;
		foreach (Module::getPaymentModules() as $module)
			if ($module['name'] == 'sydneyecommerce')
			{
				$authorized = true;
				break;
			}

		if (!$authorized)
		{
			$json['error'] = 'This payment method is not available.';
			echo json_encode($json);exit;
		}

		$currency = $this->context->currency;
		$customer = new Customer($cart->id_customer);
		
		if (!Validate::isLoadedObject($customer))
		{
			$json['error'] = 'Please login to continue';
			echo json_encode($json);exit;
		}
			
		$cart_total = number_format($cart->getOrderTotal(true, Cart::BOTH), 2, '.', '');

		$params = array('vpc_Version'         => '2.5',
                      'vpc_Command'           => 'pay',
                      'vpc_MerchTxnRef'       => $cart->id,
                      'vpc_AccessCode'        => $this->module->access_code,                      
                      'vpc_Merchant'          => $this->module->merchant_id, 
                      'vpc_OrderInfo'         => 'Comweb order',
                      'vpc_Amount'            => $cart_total * 100,
                      'vpc_CardNum'           => $_POST['sydneyecommerce_card_num'],
                      'vpc_CardSecurityCode'  => $_POST['sydneyecommerce_card_code'],
                      'vpc_CardExp'           => substr($_POST['sydneyecommerce_exp_date_y'], 2, 2).$_POST['sydneyecommerce_exp_date_m'],
                      'vpc_Locale'            => 'en',
                      'vpc_Currency'          => $currency->iso_code       
                      );
					 
		$post_string = '';
		foreach ($params as $key => $value) {
			$post_string .= $key . '=' . urlencode(trim($value)) . '&';
		}

		$post_string = substr($post_string, 0, -1);
		$curl = curl_init($this->module->gateway_url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string);
		$result = curl_exec($curl);
		$curl_error = curl_error($curl);
		curl_close($curl);
		
		if ($result != '') {
			parse_str($result, $output);
			
			$vpc_ReceiptNo = isset($output['vpc_ReceiptNo']) ? $output['vpc_ReceiptNo'] : '';
			$vpc_TxnResponseCode = isset($output['vpc_TxnResponseCode']) ? $output['vpc_TxnResponseCode'] : '';
			$vpc_TransactionNo = isset($output['vpc_TransactionNo']) ? $output['vpc_TransactionNo'] : 1;
			$vpc_Message = isset($output['vpc_Message']) ? $output['vpc_Message'] : '';
			
			$this->context->cookie->vpc_ReceiptNo = $vpc_ReceiptNo;
			$this->context->cookie->vpc_TransactionNo = $vpc_TransactionNo;
			
			if($vpc_TxnResponseCode == '0' || $vpc_TxnResponseCode == '00') {
				$this->module->validateOrder($cart->id, Configuration::get('PS_OS_PAYMENT'), $cart_total, $this->module->displayName, ' Transaction No: ' .$vpc_TransactionNo . ',  Receipt No: ' . $vpc_ReceiptNo, array('transaction_id'=>$vpc_TransactionNo), (int)$currency->id, false, $customer->secure_key);
				$success_url = 'index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key;
				$json['success'] = $success_url;
			} else {
				$json['error'] = $this->getError($vpc_TxnResponseCode);
			}
		} else {
			$json['error'] = $curl_error;
		}
		echo json_encode($json);exit;
	}
	
	public function getError($responseCode){
		switch ($responseCode) {
            case "0" : $result = "Transaction Approved"; break;
            case "?" : $result = "Transaction status is unknown"; break;
            case "E" : $result = "Referred"; break;
            case "1" : $result = "Transaction could not be processed"; break;
            case "2" : $result = "Transaction declined – contact issuing bank "; break;
            case "3" : $result = "No reply from Processing Host"; break;
            case "4" : $result = "Card Expired"; break;
            case "5" : $result = "Insufficient funds"; break;
            case "6" : $result = "Error Communicating with Bank"; break;
            case "7" : $result = "Payment Server detected an error"; break;
            case "8" : $result = "Transaction Declined - Transaction Type Not Supported"; break;
            case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
            case "A" : $result = "Transaction Aborted"; break;
            case "C" : $result = "Transaction Cancelled"; break;
            case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
            case "F" : $result = "3D Secure Authentication failed"; break;
            case "I" : $result = "Card Security Code verification failed"; break;
            case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
            case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
            case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
            case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
            case "S" : $result = "Duplicate SessionID (Amex Only)"; break;
            case "T" : $result = "Address Verification Failed"; break;
            case "U" : $result = "Card Security Code Failed"; break;
            case "V" : $result = "Address Verification and Card Security Code Failed"; break;
            default  : $result = "Unable to be determined";
		}
				
		return $result;
	}
}