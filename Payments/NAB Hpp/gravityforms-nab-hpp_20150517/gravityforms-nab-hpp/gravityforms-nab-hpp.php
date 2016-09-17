<?php
/*
Plugin Name: Gravity Forms NAB HPP Add-On
Plugin URI: http://www.gravityforms.com
Description: NAB HPP payment extension for Gravity Forms
Version: 1.1
Author: Sydney Ecommerce
Author URI: http://www.sydneyecommerce.com.au

------------------------------------------------------------------------
Copyright 2015 Sydney Ecommerce Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


//------------------------------------------
if (class_exists("GFForms")) {
    GFForms::include_payment_addon_framework();

    class GFNabHpp extends GFPaymentAddOn {
		protected $_version = "1.0.1"; 
        protected $_min_gravityforms_version = "1.8.12";
        protected $_slug = 'nabhpp';
        protected $_path = 'gravityforms-nab-hpp/gravityforms-nab-hpp.php';
        protected $_full_path = __FILE__;
        protected $_title = 'Gravity Forms NAB HPP';
        protected $_short_title = 'NAB HPP';
        protected $_supports_callbacks = true;
        protected $_requires_credit_card = false;

		public function init_frontend() {
			parent::init_frontend();
			if(isset($_GET['nab_return']) && $_GET['nab_return'] == 1)
				add_filter( 'the_content', array( $this, 'result_page' ),20);
		}
		
        public function feed_settings_fields() {
		  $default_settings = parent::feed_settings_fields();
		
		  //--add NAB merchant ID field
		  $fields = array(
			array(
				'name'     => 'merchant_id',
				'label'    => 'Merchant ID',
				'type'     => 'text',
				'class'    => 'medium',
				'required' => true,
				'tooltip'  => 'Your NAB Merchant ID'
			),
			array(
				'name'          => 'mode',
				'label'         => 'Mode',
				'type'          => 'radio',
				'choices'       => array(
									   array( 'id' => 'gf_nab_mode_production', 'label' => 'Production', 'value' => 'production' ),
									   array( 'id' => 'gf_nab_mode_test', 'label' => 'Test', 'value' => 'test' ),
		
								   ),
				'horizontal'    => true,
				'default_value' => 'production',
				'tooltip'       => 'Select Production to receive live payments. Select Test for testing purposes'
			),
		  );
		
		  $default_settings = parent::add_field_after( 'feedName', $fields, $default_settings );
		  return $default_settings;
		}
		
		function redirect_url( $feed, $submission_data, $form, $entry ){
			global $wp;
			
			if($feed['meta']['mode'] == 'test')
				$gateway_url = 'https://transact.nab.com.au/test/hpp/payment';
			else
				$gateway_url = 'https://transact.nab.com.au/live/hpp/payment';
				
			//return url
			$current_url = home_url(add_query_arg(array(),$wp->request));
			$return_link_url = add_query_arg('bank_reference', '', $current_url);
			$return_link_url = add_query_arg('payment_amount', '', $return_link_url);
			$return_link_url = add_query_arg('payment_number', '', $return_link_url);
			$return_link_url = add_query_arg('payment_reference', '', $return_link_url);
			
			//reply url
			$reply_link_url = add_query_arg('bank_reference', '', get_site_url());
			$reply_link_url = add_query_arg('payment_amount', '', $reply_link_url);
			$reply_link_url = add_query_arg('payment_number', '', $reply_link_url);
			$reply_link_url = add_query_arg('payment_reference', '', $reply_link_url);
			
			$request = array();
			$request['vendor_name'] = $feed['meta']['merchant_id'];
			$request['payment_reference'] = $entry['id'];
			$request['receipt_address'] = $entry[$feed['meta']['billingInformation_email']];
			$request['return_link_text'] = 'Click Here to Return to the Home Page';
			$request['return_link_url'] = add_query_arg('nab_return', 1, $return_link_url);
			$request['reply_link_url'] = add_query_arg('callback', 'nabhpp', $reply_link_url);
			
			foreach($submission_data['line_items'] as $item){
				$request[$item['name']] =  $item['quantity'] . ',' . number_format($item['unit_price'],2,'.','');
			}
			//print_r($request);exit;
			
			return $gateway_url . '?' . http_build_query($request);
		}
		
		function callback(){
			//mail('vnphpexpert@gmail.com', 'Gravity calback', print_r($_GET, true));
			$return = array();
			if(!empty($_GET['payment_reference']) && !empty($_GET['bank_reference'])) {
				$return = array(
					'type'             => 'complete_payment',
					'amount'           => $_GET['payment_amount'],
					'transaction_id'   => $_GET['bank_reference'],
					'entry_id'         => $_GET['payment_reference'],
					'payment_status'   => 'Paid'
				);
				
				//send notification
				$lead = RGFormsModel::get_lead( $_GET['payment_reference'] );
				$form = RGFormsModel::get_form_meta($lead["form_id"]);
				foreach($form[notifications] as $key=>$value){
					GFCommon::send_notification($value, $form, $lead);
				}
			}
			return $return;
		}
		
		function post_callback( $callback_action, $result ){
			
		}
		
		function result_page( ) {
			if(isset($_GET['nab_return']) && $_GET['nab_return'] == 1) {
				$form_info = RGFormsModel::get_form_meta(1);//print_r($form_info['confirmations']);
				$message = '';
				if(isset($form_info['confirmations']) && count($form_info['confirmations'])){
					foreach($form_info['confirmations'] as $key=>$value){
						if($value['isDefault'] == 1)
							$message = $value['message'];
					}
				}
				
				$message .= '<br/><br/><strong>Your transaction info:</strong><br/>';
				$message .= 'bank_reference: '.$_GET['bank_reference'].'<br/>';
				$message .= 'payment_amount: $'.$_GET['payment_amount'].'<br/>';
				$message .= 'payment_number: '.$_GET['payment_number'].'<br/><br/>';
				return $message;
			}
		}
    }

    new GFNabHpp();
}