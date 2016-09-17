<?php
/*
Plugin Name: Woocommerce Debit Success Payment Gateway
Plugin URI: http://www.sydneyecommerce.com.au
Description: This plugin extends the woocommerce payment gateways to add in Debit Success gateway.
Version: 1.0.1
Author: SydneyEcommerce
Author URI: http://www.sydneyecommerce.com.au
*/


/*  Copyright 2012  SydneyEcommerce  (email : sydneyecommerce@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
*/


/* Add a custom payment class to woocommerce
------------------------------------------------------------ */
add_action( 'plugins_loaded', 'woocommerce_debitsuccess_init', 0 );
function woocommerce_debitsuccess_init() {
    
    if ( !class_exists( 'WC_Payment_Gateway' ) ) return; // if the Woocommerce payment gateway class is not available, do nothing
	
		class WC_Gateway_DebitSuccess extends WC_Payment_Gateway {
		
		public function __construct() {
        	$this->id				= 'debitsuccess';
        	$this->icon 			= WP_PLUGIN_URL . "/" . plugin_basename( dirname(__FILE__)) . '/images/logo.png';
        	$this->has_fields 		= false;
			$this->method_title     = __( 'Debit Success', 'woocommerce' );
			
			$this->supports           = array(
				'products',
			);
			
			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();
	
			// Define user set variables
			$this->title 		= $this->get_option( 'title' );
			$this->description  = $this->get_option( 'description' );
			$this->username   = $this->get_option( 'username' );
			$this->password   = $this->get_option( 'password' );
			$this->enviroment   = $this->get_option( 'enviroment' );
			
			$this->account_country   = $this->get_option( 'account_country' );
			$this->contract_prefix   = $this->get_option( 'contract_prefix' );
			$this->term_type   = $this->get_option( 'term_type' );
			
			$this->term_value   = $this->get_option( 'term_value' );
			$this->fixed_term   = $this->get_option( 'fixed_term' );
			$this->fixed_total_value   = $this->get_option( 'fixed_total_value' );
			$this->payment_types   = $this->get_option( 'payment_types' );
			$this->installment_amount   = $this->get_option( 'installment_amount' );
			$this->schedule_frequency =  $this->get_option( 'schedule_frequency' );

			$this->test_gateway_url   = 'https://oc-test.services.debitsuccess.com/DsWebService/DSServices.svc?wsdl';
			$this->live_gateway_url   = 'https://oc-test.services.debitsuccess.com/DsWebService/DSServices.svc?wsdl';
			
			//$this->notify_url         = WC()->api_request_url( 'WC_Gateway_SecurePayFrame' );

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) );

			add_action('woocommerce_receipt_' . $this->id, array(&$this, 'receipt_page'));
			
			add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_debitsuccess_scripts' ) );
    	}
		
		function init_form_fields() {
			$payment_types = array('Payment Plan'=>'Payment Plan', 'Once Off Payment'=>'Once Off Payment');
			$schedule_frequency = array('Weekly'=>'Weekly', 'Fortnightly'=>'Fortnightly','FourWeekly'=>'FourWeekly', 'Monthly'=>'Monthly','BiMonthly'=>'BiMonthly', 'Quarterly'=>'Quarterly');
    		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( 'Enable Debit Success Payment', 'woocommerce' ),
							'default' => 'yes'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
							'default' => __( 'Pay with Debit Success', 'woocommerce' ),
							'desc_tip'      => true,
						),
			'description' => array(
							'title' => __( 'Customer Message', 'woocommerce' ),
							'type' => 'textarea',
							'description' => __( 'Give the customer instructions for paying via Debit Success.', 'woocommerce' ),
							'default' => __( 'Content here', 'woocommerce' )
						),
			'username' => array(
							'title' => __( 'Username', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'password' => array(
							'title' => __( 'Password', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'account_country' => array(
							'title' => __( 'Account Country', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => 'Australia',
							'options' => array(
								  'Australia' => 'Australia',
								  'NewZealand' => 'NewZealand',
								  'UnitedStatesOfAmerica' => 'UnitedStatesOfAmerica',
							 )
						),
			'contract_prefix' => array(
							'title' => __( 'Contract Prefix', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'term_type' => array(
							'title' => __( 'Term Type', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => 'Months',
							'options' => array(
								  'Months' => 'Months',
								  'Payments' => 'Payments'
							 )
						),
			'term_value' => array(
							'title' => __( 'Term', 'woocommerce' ),
							'type' => 'text',
							'description' => '',
							'default' => ''
						),
			'fixed_term' => array(
							'title' => __( 'Fixed Term', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '', 'woocommerce' ),
							'default' => 'no'
						),
			'fixed_total_value' => array(
							'title' => __( 'Fixed Total Value', 'woocommerce' ),
							'type' => 'checkbox',
							'label' => __( '', 'woocommerce' ),
							'default' => 'no'
						),
			'payment_types' => array(
							'title' => __( 'Payment Type', 'woocommerce' ),
							'type'              => 'multiselect',
							'class'             => 'chosen_select',
							'css'               => 'width: 450px;',
							'default'           => '',
							'description'       => __( '', 'woocommerce' ),
							'options'           => $payment_types,
						),
			'installment_amount' => array(
							'title' => __( 'Installment Amount', 'woocommerce' ),
							'type' => 'text',
							'description' => 'Eg: 10,15,20,25,...',
							'default' => ''
						),
			'schedule_frequency' => array(
							'title' => __( 'Schedule Frequency', 'woocommerce' ),
							'type'              => 'multiselect',
							'class'             => 'chosen_select',
							'css'               => 'width: 450px;',
							'default'           => '',
							'description'       => __( '', 'woocommerce' ),
							'options'           => $schedule_frequency,
						),
			'enviroment' => array(
							'title' => __( 'Enviroment', 'woocommerce' ),
							'type' => 'select',
							'description' => '',
							'default' => 'test',
							'options' => array(
								  'live' => 'Live',
								  'test' => 'Test'
							 )
						),
			);

    	}

		public function payment_fields() {
			$total = WC()->cart->total;
			$cardtypes = array('American Express', 'Mastercard', 'Visa');
		?>
				<fieldset>
					<legend>Payment Method</legend>
							<div>
							<input type="radio" name="db_payment_method" id="db_payment_method_cc" value="CreditCard" onclick="dbShowHide('db_creditcard', 'db_bankaccount');" checked="checked"/>&nbsp;<label for="db_payment_method_cc">Credit Card</label> &nbsp;&nbsp;
							<input type="radio" name="db_payment_method" id="db_payment_method_bank" value="BankAccount" onclick="dbShowHide('db_bankaccount', 'db_creditcard');"/>&nbsp;<label for="db_payment_method_bank">Direct Debit</label>
							</div>
              				<!-- Show input boxes for credit card-->
              				<div id="db_creditcard">
								<!-- Credit card type -->
                    			<p class="form-row">
                      				<label for="db_cardtype"><?php echo __( 'Card type', 'woocommerce' ) ?> <span class="required">*</span></label>
                      				<select name="db_cardtype" id="db_cardtype" class="woocommerce-select">
                  						<?php  foreach( $cardtypes as $type ) { ?>
                            				<option value="<?php echo $type ?>"><?php _e( $type, 'woocommerce' ); ?></option>
                  						<?php } ?>
                       				</select>
                    			</p>
								<!-- Credit card holder -->
                    			<p class="form-row">
									<label for="db_cc_name"><?php echo __( 'Card Holder', 'woocommerce' ) ?> <span class="required">*</span></label>
									<input type="text" class="input-text" id="db_cc_name" name="db_cc_name" maxlength="16" />
                    			</p>
								<!-- Credit card number -->
                    			<p class="form-row">
									<label for="db_ccnum"><?php echo __( 'Credit Card number', 'woocommerce' ) ?> <span class="required">*</span></label>
									<input type="text" class="input-text" id="db_ccnum" name="db_ccnum" maxlength="16" />
                    			</p>
								<div class="clear"></div>
								<!-- Credit card expiration -->
                    			<p class="form-row">
                      				<label for="db_cc-expire-month"><?php echo __( 'Expiration date', 'woocommerce') ?> <span class="required">*</span></label>
                      				<select name="db_expmonth" id="db_expmonth" class="woocommerce-select woocommerce-cc-month">
                        				<option value=""><?php _e( 'Month', 'woocommerce' ) ?></option><?php
				                        $months = array();
				                        for ( $i = 1; $i <= 12; $i ++ ) {
				                          $timestamp = mktime( 0, 0, 0, $i, 1 );
				                          $months[ date( 'n', $timestamp ) ] = date( 'F', $timestamp );
				                        }
				                        foreach ( $months as $num => $name ) {
				                          printf( '<option value="%s">%s</option>', sprintf('%02d', $num), $name );
				                        } ?>
                      				</select>
                      				<select name="db_expyear" id="db_expyear" class="woocommerce-select woocommerce-cc-year">
                        				<option value=""><?php _e( 'Year', 'woocommerce' ) ?></option><?php
				                        $years = array();
				                        for ( $i = date( 'y' ); $i <= date( 'y' ) + 15; $i ++ ) {
				                          printf( '<option value="20%u">20%u</option>', $i, $i );
				                        } ?>
                      				</select>
                    			</p>
								<div class="clear"></div>
				                <p class="form-row">
				                        <label for="db_cvv"><?php _e( 'Card security code', 'woocommerce' ) ?> <span class="required">*</span></label>
				                        <input oninput="validate_cvv(this.value)" type="text" class="input-text" id="db_cvv" name="db_cvv" maxlength="4" style="width:45px" />
				                        <span class="help"><?php _e( '3 or 4 digits usually found on the signature strip.', 'woocommerce' ) ?></span>
				                </p>
						</div>
						
						<!-- Show input boxes for direct debit-->
              			<div id="db_bankaccount" style="display:none;">
								<!-- Account holder -->
                    			<p class="form-row">
									<label for="db_account_name"><?php echo __( 'Account Holder', 'woocommerce' ) ?> <span class="required">*</span></label>
									<input type="text" class="input-text" id="db_account_name" name="db_account_name" maxlength="16" />
                    			</p>
								<!-- Account number -->
                    			<p class="form-row">
									<label for="db_account_number"><?php echo __( 'Account number', 'woocommerce' ) ?> <span class="required">*</span></label>
									<input type="text" class="input-text" id="db_account_number" name="db_account_number" maxlength="16" />
                    			</p>
						</div>
            	</fieldset>
				<?php
				if(count($this->payment_types)){
				?>
				<fieldset>
					<legend>Payment Option</legend>
					<div>
					<?php
					foreach($this->payment_types as $key=>$value){
					?>
						<input type="radio" name="db_payment_type" id="db_payment_type_<?php echo $key;?>" value="<?php echo $value;?>" onclick="dbShowHidePlan('<?php echo $value;?>');" <?php if($value == 'Once Off Payment' || (count($this->payment_types) == 1)) echo  'checked';?>/>&nbsp;<label for="db_payment_type_<?php echo $key;?>"><?php echo $value;?></label> &nbsp;&nbsp;
					<?php
					}
					?>
					</div>
					<div id="db_plan" <?php if((count($this->payment_types) == 1 && $this->payment_types[0] == 'Once Off Payment') || count($this->payment_types) == 2) echo 'style="display:none;"';?>>
                    			<p class="form-row">
									<label for="db_instalment_amount"><?php echo __( 'Installment Amount', 'woocommerce' ) ?></label>
									<select name="db_instalment_amount" id="db_instalment_amount" class="woocommerce-select" onchange="dbShowTotalInfo(<?php echo $total;?>);">
									<?php
									$installment_amount = explode(',', $this->installment_amount);
									foreach($installment_amount as $item_amount){
									?>
										<option value="<?php echo number_format($item_amount, 2, '.', '');?>">$<?php echo number_format($item_amount, 2, '.', '');?></option>
									<?php
									}
									?>
									</select>
								
									<select name="db_schedulefrequency" id="db_schedulefrequency" class="woocommerce-select" onchange="dbShowTotalInfo(<?php echo $total;?>);">
									<?php
									if(!$this->schedule_frequency)$this->schedule_frequency = array('Weekly');
									foreach($this->schedule_frequency as $item_frequency){
									?>
										<option value="<?php echo $item_frequency;?>"><?php echo $item_frequency;?></option>
									<?php
									}
									?>
									</select>
                    			</p>
					</div>
					<div id="db_total_oneoff">
						<p class="form-row">
							<span id="db_total_oneoff_info" style="font-size:20px; color:red;">Total: $<?php echo number_format($total, 2, '.', '');?></span>
						</p>
					</div>
					<div id="db_total_plan" <?php if((count($this->payment_types) == 1 && $this->payment_types[0] == 'Once Off Payment') || count($this->payment_types) == 2) echo 'style="display:none;"';?>>
						<p class="form-row">
							<span id="db_total_plan_info" style="font-size:20px; color:red;">
							<?php
							$Term = ceil($total/$installment_amount[0]);
							$order_total = $Term * $installment_amount[0];
							?>
							Total Amount: $<?php echo number_format($order_total, 2, '.', '');?><br/>
							Number of Payments: <?php echo $Term;?><br/>
							Frequency: <?php echo $this->schedule_frequency[0];?>
							</span>
						</p>
					</div>
				</fieldset>
				<?php
				}
				?>
		<?php
		
		}
		/**
	 * Process the payment and return the result
		 **/
		function process_payment( $order_id ) {
			require_once("libs/debit_success.php");
			
			$countries = array('AU'=>'Australia', 'NZ'=>'NewZealand', 'US'=>'UnitedStatesOfAmerica');//NotSpecified
			$states = array('ACT'=>'AustralianCapitalTerritory', 'NSW'=>'NewSouthWales', 'NT'=>'NorthernTerritory', 'QLD'=>'Queensland', 'SA'=>'SouthAustralia', 'TAS'=>'Tasmania', 'VIC'=>'Victoria', 'WA'=>'WesternAustralia');
			
			$error = '';
			if($_POST['db_payment_method'] == 'CreditCard'){
				if($_POST['db_cc_name'] == ''){
					$error = 'Please input card holder';
				}elseif($_POST['db_ccnum'] == ''){
					$error = 'Please input card number';
				}elseif($_POST['db_expmonth'] == ''){
					$error = 'Please input expiry month';
				}elseif($_POST['db_expyear'] == ''){
					$error = 'Please input expiry year';
				}elseif($_POST['db_cvv'] == ''){
					$error = 'Please input CVV';
				}
			} else {
				if($_POST['db_account_name'] == ''){
					$error = 'Please input account holder';
				}elseif($_POST['db_account_number'] == ''){
					$error = 'Please input account number';
				}
			}
			
			if($error != ''){
				wc_add_notice( $error, $notice_type = 'error' );
				return;
			}
			
			$order = new WC_Order( $order_id );
			
			//$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
			$tomorrow = strtotime("tomorrow");
			$DateAccountStarted = date("Y-m-d", $tomorrow);
			$start_date = date("Y-m-d", $tomorrow);
			
			//send request to Debit Success
			if($this->enviroment == 'test')
				$gateway_url = $this->test_gateway_url;
			else
				$gateway_url = $this->live_gateway_url;
			
			//Debit success merchant info
			$user = new DebitSucessUser(); 
			$user->Username = $this->username;
			$user->Password = $this->password;
			
			//generate account request
			$request = new RequestPostCustomerAccount();
			$request->User = $user;
			$request->RequestInitiator = "";
			$request->ContractPrefix = $this->contract_prefix;
			
			//customer details
			$request->FirstName = $order->billing_first_name;
			$request->LastName = $order->billing_last_name;
			
			//account details
			$order_total = $order->order_total;
			if($_POST['db_payment_type'] == 'Once Off Payment'){
				$Term = 1;
			} elseif($_POST['db_payment_type'] == 'Payment Plan'){
				$Term = ceil($order->order_total/$_POST['db_instalment_amount']);
				$order_total = $Term * $_POST['db_instalment_amount'];
			}
			$request->DateAccountStarted = $DateAccountStarted;
			$request->Term = $Term;
			$request->TermType = $this->term_type;
			$request->AccountNotes = "";
			$request->ExternalAccountReferenceNo = $order_id;
			$request->FixedTerm = $this->fixed_term == 'yes'? 1 : 0; // true/false
			$request->AccountCountry = $this->account_country;
			$request->FixTotalValue = $this->fixed_total_value == 'yes'? 1 : 0;// true/false 
			
			if($this->fixed_total_value == 'yes'){
				$request->TotalValue = $order_total;// only relevant when FixTotalValue is true
			}
			
			//payment method details
			if($_POST['db_payment_method'] == 'CreditCard'){
				$request->AccountNo = $_POST['db_ccnum'];
				$request->ExpiryDate = $_POST['db_expyear'] . '-' . $_POST['db_expmonth']; // date formatted YYYY-MM-DD
				$request->AccountHolder = $_POST['db_cc_name'];
				$request->AccountType = "CreditCard";
				$request->CreditCardType = $_POST['db_cardtype'];
			} else {
				$request->AccountNo = $_POST['db_account_number'];
				$request->AccountHolder = $_POST['db_account_name'];
				$request->AccountType = "BankAccount";
				$request->CreditCardType = "None";
			}
			
			$payment_info = 'Payment Method: '.$_POST['db_payment_method'].', Payment Option: ' . $_POST['db_payment_type'] . ', Number of Payments: ' . $Term;
			//payment details
			if($_POST['db_payment_type'] == 'Once Off Payment'){
				$request->InitialOneOffScheduleDescription = "";
				$request->InitialOneOffScheduleInstalment = $order_total;
				$request->InitialOneOffScheduleStartDate = $start_date;
			} elseif($_POST['db_payment_type'] == 'Payment Plan'){
				$request->RecurringScheduleDescription = "";
				$request->RecurringScheduleFrequency = $_POST['db_schedulefrequency'];// Weekly, Fortnightly, FourWeekly, Monthly, BiMonthly or Quarterly 
				$request->RecurringScheduleInstalment = $_POST['db_instalment_amount'];
				$request->RecurringScheduleStartDate = $start_date;// date formatted YYYY-MM-DD
				
				$payment_info .= ', Installment Amount: $' . $_POST['db_instalment_amount'] . ' per ' .  $_POST['db_schedulefrequency'];
			}
			
			//address details
			$request->BillingAddress = $order->billing_address_1;
			$request->BillingCity = $order->billing_city;
			$request->BillingCountry = $countries[$order->billing_country]; // NewZealand / Australia / UnitedStaetsOfAmerica
			$request->BillingPostcode = $order->billing_postcode; 
			$request->BillingState  = $states[$order->billing_state]; // See table
			$request->BillingSuburb = $order->billing_city;
			
			//other
			$request->EmailAddress = $order->billing_email;
			$request->MobileNumber = $order->billing_phone;
			//print_r($request);exit;
			try 
			{ 
				  $client = new SoapClient($gateway_url); 
				  $response = $client->PostCustomerAccount(array("request"=>$request));
				  if($response->PostCustomerAccountResult->Status == 'Succeed'){
				  		$AccountReferenceNo = $response->PostCustomerAccountResult->AccountReferenceNo;
				  		  $order->add_order_note( __('Payment completed, AccountReferenceNo: '.$AccountReferenceNo . ', ' . $payment_info, 'woocommerce') );
						  $order->payment_complete($AccountReferenceNo);
						 // Return thank you redirect
						  return array (
							  'result'   => 'success',
							  'redirect' => $this->get_return_url( $order ),
						  );
				  } else {
				  		$msg = $response->PostCustomerAccountResult->ResponseNotes->ResponseMessageNote->Note;
				  		wc_add_notice( 'Payment request error: '.  $msg, $notice_type = 'error' );
						return;
				  }
				   
				  /*echo "<pre>";
				  print_r($request);
				  print_r($response);                                            
				  echo "</pre>";*/
			}  
			catch (Exception $e)  
			{
				wc_add_notice( 'Caught exception: '.  $e->getMessage(), $notice_type = 'error' );
				return;
			}exit;
		}
		
		/**
		 * receipt_page
		 **/
		function receipt_page( $order ) {
			echo '<p>' . __( 'Thank you for your order.', 'woocommerce' ) . '</p>';
		}
		
		function thankyou_page(){
			/*$order = new WC_Order( $_GET['order-received'] );
			
			WC()->api->includes();
			WC()->api->register_resources( new WC_API_Server( '/' ) );
			$notes = WC()->api->WC_API_Orders->get_order_notes($_GET['order-received']);
			
			if(isset($notes['order_notes'][0]['note']))
				echo $notes['order_notes'][0]['note'];
			*/
			//echo '<strong>Transaction ID: ' . $_GET['txnid'];
			//echo '<br/>Transaction status: ' . $_GET['restext'];
			//echo '<br/>Amount: $' . $_GET['amount']/100 . ' ' .  $_GET['currency'].'</strong>';
		}
		
		public function add_debitsuccess_scripts() {
		  //wp_enqueue_script( 'jquery' );
		  wp_enqueue_script( 'check_cvv', WP_PLUGIN_URL . "/" . plugin_basename( dirname(__FILE__)) . '/js/check_cvv.js', array( 'jquery' ), 1.0 );
		}
	}

	/* Add our new payment gateway to the woocommerce gateways 
	------------------------------------------------------------ */
 
	add_filter( 'woocommerce_payment_gateways', 'add_woocommerce_debitsuccess_payment_gateway' );
	function add_woocommerce_debitsuccess_payment_gateway( $methods ) {
		$methods[] = 'WC_Gateway_DebitSuccess'; return $methods;
	}
}