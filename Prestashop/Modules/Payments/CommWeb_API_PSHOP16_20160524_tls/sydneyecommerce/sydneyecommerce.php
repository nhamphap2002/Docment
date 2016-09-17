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

*  @version  Release: $Revision: 7095 $

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)

*  International Registered Trademark & Property of PrestaShop SA

*/

if (!defined('_PS_VERSION_'))
	exit;

class Sydneyecommerce extends PaymentModule
{
	private $_html = '';
	private $_postErrors = array();
	public $gateway_url = 'https://migs.mastercard.com.au/vpcdps';

	public function __construct()
	{
		$this->name = 'sydneyecommerce';
		$this->tab = 'payments_gateways';
		$this->version = '1.0';
		$this->author = 'SydneyEcommerce.com.au';

		$this->currencies = true;
		$this->currencies_mode = 'checkbox';

		$config = Configuration::getMultiple(array('MIGS_MERCHANT_ID', 'MIGS_ACCESS_CODE', 'MIGS_CARD_TYPES' ));

		if (isset($config['MIGS_MERCHANT_ID']))
			$this->merchant_id = $config['MIGS_MERCHANT_ID'];
			
		if (isset($config['MIGS_ACCESS_CODE']))
			$this->access_code = $config['MIGS_ACCESS_CODE'];
			
		if (isset($config['MIGS_CARD_TYPES']))
			$this->card_types = $config['MIGS_CARD_TYPES'];
			
		parent::__construct();


		$this->displayName = $this->l('Migs Payment Gateway');
		$this->description = $this->l('Accept payments by Migs Gateway.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your merchant info?');

	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('paymentReturn'))
			return false;
		return true;
	}

	public function uninstall()
	{
		if (!Configuration::deleteByName('MIGS_MERCHANT_ID') || !Configuration::deleteByName('MIGS_ACCESS_CODE') || !Configuration::deleteByName('MIGS_CARD_TYPES') || !parent::uninstall())
			return false;
		return true;
	}

	private function _postValidation()
	{
		if (Tools::isSubmit('btnSubmit'))
		{
			if (!Tools::getValue('merchant_id'))
				$this->_postErrors[] = $this->l('Merchant ID is required.');
				
			if (!Tools::getValue('access_code'))
				$this->_postErrors[] = $this->l('Access Code is required.');
		}

	}

	private function _postProcess()
	{
		if (Tools::isSubmit('btnSubmit'))
		{
			Configuration::updateValue('MIGS_MERCHANT_ID', Tools::getValue('merchant_id'));
			Configuration::updateValue('MIGS_ACCESS_CODE', Tools::getValue('access_code'));
			Configuration::updateValue('MIGS_CARD_TYPES', implode(',', Tools::getValue('card_types')));
			$this->card_types = Configuration::get('MIGS_CARD_TYPES');
		}

		$this->_html .= $this->displayConfirmation($this->l('Settings updated'));

	}

	private function _displayCheckoutPayment()
	{
		$this->_html .= '<img src="../modules/sydneyecommerce/logo.png" style="float:left; margin-right:15px;"><b>'.$this->l('This module allows you to accept payments by Migs Payment Gateway.').'</b><br /><br />';

	}



	private function _displayForm()
	{
		$selected_card_types = explode(",", $this->card_types);
		$card_types = array(
								'mastercard'  => 'Mastercard',				
								'visa'        => 'Visa',
								'amex'        => 'Amex',
								'discover'    => 'Discover'	
						);
						
		$card_menu = '';    
		while (list($key, $value) = each($card_types)) {
		  $selected = '';
		  if(in_array($key, $selected_card_types)) {
			$selected = ' checked ';
		  }     
		  $card_menu .= '<input type="checkbox" name="card_types[]" value="'.$key.'" '.$selected.'>&nbsp;&nbsp;'.$value.'<br>';
		}
		
		$this->_html .=

		'<form action="'.Tools::htmlentitiesUTF8($_SERVER['REQUEST_URI']).'" method="post">

			<fieldset>

			<legend>'.$this->l('Merchant settings').'</legend>

				<table border="0" width="500" cellpadding="0" cellspacing="0" id="form">

					<tr><td colspan="2">'.$this->l('Please specify your merchant info').'.<br /><br /></td></tr>

					<tr><td width="130" style="height: 35px;">'.$this->l('Merchant ID').'</td><td><input type="text" name="merchant_id" value="'.htmlentities(Tools::getValue('merchant_id', $this->merchant_id), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
					<tr><td width="130" style="height: 35px;">'.$this->l('Access Code').'</td><td><input type="text" name="access_code" value="'.htmlentities(Tools::getValue('access_code', $this->access_code), ENT_COMPAT, 'UTF-8').'" style="width: 300px;" /></td></tr>
					<tr><td width="130" style="height: 35px;">'.$this->l('Card Types').'</td><td>'.$card_menu.'</td></tr>
					<tr><td colspan="2" align="center"><input class="button" name="btnSubmit" value="'.$this->l('Update settings').'" type="submit" /></td></tr>

				</table>

			</fieldset>

		</form>';

	}


	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('btnSubmit'))
		{
			$this->_postValidation();
			if (!count($this->_postErrors))
				$this->_postProcess();
			else
				foreach ($this->_postErrors as $err)

					$this->_html .= '<div class="alert error">'.$err.'</div>';

		}

		else
			$this->_html .= '<br />';

		$this->_displayCheckoutPayment();

		$this->_displayForm();

		return $this->_html;

	}

	public function hookPayment($params)
	{
		global $cookie;
		if (!$this->active)
			return;
		
		$card_images = '';
		$selected_card_types = explode(",", $this->card_types);
		if(count($selected_card_types)){
			foreach($selected_card_types as $card){
				$card_images .= '<img src="'.$this->_path.'images/'.$card.'.gif" alt="">&nbsp;';
			}
		}
		
		$this->smarty->assign(array(
			'card_images' => $card_images,
			'this_path' => $this->_path,
			'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
		));
		return $this->display(__FILE__, 'payment.tpl');

	}

	public function hookPaymentReturn($params)
	{
		if (!$this->active)
			return;
			
		$this->smarty->assign(array(
				'order_ref' => $params['objOrder']->reference,
				'trans_id' => $this->context->cookie->vpc_TransactionNo,
				'receipt_no' => $this->context->cookie->vpc_ReceiptNo,
				'total' => $params['total_to_pay'],
				'email' => $this->context->customer->email,
		));

		return $this->display(__FILE__, 'payment_return.tpl');
	}
}