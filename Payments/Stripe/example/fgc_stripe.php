<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fgc_stripe
 *
 * @author LeXuanChien
 */
include dirname(__FILE__) . '/stripe/init.php';

class FgcStripe {

    public static function setApiKey($apiKey) {
	\Stripe\Stripe::setApiKey($apiKey);
    }

    /**
     * Charge
     * @param type $amount
     * @param type $currency
     * @param type $card_number
     * @param type $expiry_month
     * @param type $expiry_year
     * @param type $cvc
     * @return type
     */
    public static function charge($amount, $currency, $card_number, $expiry_month, $expiry_year, $cvc, $name) {
	$card = array(
	    'number' => $card_number,
	    'exp_month' => $expiry_month,
	    'exp_year' => $expiry_year,
	    'cvc' => $cvc,
	    'name' => $name
	);

	$charge = array(
	    'amount' => $amount,
	    'currency' => $currency,
	    'card' => $card
	);
	try {
	    $ch = Stripe\Charge::create($charge);
	} catch (\Stripe\Error\Card $e) {
	    // Since it's a decline, \Stripe\Error\Card will be caught
	    $body = $e->getJsonBody();
	    $err = $body['error'];

	    print('Status is:' . $e->getHttpStatus() . "\n");
	    print('Type is:' . $err['type'] . "\n");
	    print('Code is:' . $err['code'] . "\n");
	    // param is '' in this case
	    print('Param is:' . $err['param'] . "\n");
	    print('Message is:' . $err['message'] . "\n");
	} catch (\Stripe\Error\InvalidRequest $e) {
	    // Invalid parameters were supplied to Stripe's API
	} catch (\Stripe\Error\Authentication $e) {
	    // Authentication with Stripe's API failed
	    // (maybe you changed API keys recently)
	} catch (\Stripe\Error\ApiConnection $e) {
	    // Network communication with Stripe failed
	} catch (\Stripe\Error\Base $e) {
	    // Display a very generic error to the user, and maybe send
	    // yourself an email
	} catch (Exception $e) {
	    // Something else happened, completely unrelated to Stripe
	}
	return $ch;
    }

    /**
     * Refund
     * @param type $amount
     * @param type $charge_id
     * @return type
     */
    public static function refund($amount, $charge_id) {
	$ch = \Stripe\Charge::retrieve($charge_id);
	$ref = $ch->refunds->create(array('amount' => $amount));
	return $ref;
    }

    public static function createCustomer($card_number, $expiry_month, $expiry_year, $cvc, $email, $name) {
	$card = array(
	    'number' => $card_number,
	    'exp_month' => $expiry_month,
	    'exp_year' => $expiry_year,
	    'cvc' => $cvc,
	    'name' => $name
	);
	$customer = \Stripe\Customer::create(array(
		    "email" => $email,
		    'card' => $card
	));
	return $customer;
    }

}
