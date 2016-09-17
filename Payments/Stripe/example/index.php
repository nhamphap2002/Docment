<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript">
            // This identifies your website in the createToken call below
//            Stripe.setPublishableKey('pk_test_c5HChEzdOmBQPpOxaydl7Deu');
//            // ...
//            jQuery(function ($) {
//                $('#payment-form').submit(function (event) {
//                    var $form = $(this);
//
//                    // Disable the submit button to prevent repeated clicks
//                    $form.find('button').prop('disabled', true);
//
//                    Stripe.card.createToken($form, stripeResponseHandler);
//
//                    // Prevent the form from submitting with the default action
//                    return false;
//                });
//                function stripeResponseHandler(status, response) {
//                    var $form = $('#payment-form');
//
//                    if (response.error) {
//                        // Show the errors on the form
//                        $form.find('.payment-errors').text(response.error.message);
//                        $form.find('button').prop('disabled', false);
//                    } else {
//                        // response contains id and card, which contains additional card details
//                        var token = response.id;
//                        // Insert the token into the form so it gets submitted to the server
//                        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
//                        // and submit
//                        $form.get(0).submit();
//                    }
//                }
//                ;
//            });
	</script>
	<h1>Thanh toan</h1>
	<form action="index.php" method="POST" id="payment-form">

	    <span class="payment-errors"></span>
	    ---------------------------customer-----------------<br/>
	    <div class="form-row">
		<label>
		    <span>Email</span>
		    <input type="text" size="20" name="email" value="lexuanchiendhv@gmail.com"/>
		</label>
	    </div>
	    -------------------------Card-------------------<br/>
	    <div class="form-row">
		<label>
		    <span>Cardholder's Name</span>
		    <input type="text" size="20" name="name" data-stripe="name" value="Cardholder's Name 12345"/>
		</label>
	    </div>
	    <div class="form-row">
		<label>
		    <span>Card Number</span>
		    <input type="text" size="20" name="card_number" data-stripe="number" value="4242424242424242"/>
		</label>
	    </div>
	    <div class="form-row">
		<label>
		    <span>CVC</span>
		    <input type="text" size="4" name="cvc" data-stripe="cvc" value="123"/>
		</label>
	    </div>
	    <div class="form-row">
		<label>
		    <span>Expiration (MM/YYYY)</span>
		    <input type="text" size="2" name="expiry_month" data-stripe="exp-month" value="11"/>
		</label>
		<span> / </span>
		<input type="text" size="4" name="expiry_year" data-stripe="exp-year" value="2016"/>
	    </div>
	    <button name="payment" type="submit">Submit Payment</button>
	</form>
	<h1>Hoan tra</h1>
	<form action="index.php" method="POST">
	    Amount:<input type="text" name="amount" value="<?php if (isset($_REQUEST['amount'])) echo $_REQUEST['amount']; ?>"/><br/>
	    Charge ID:<input type="text" name="charge" value="<?php if (isset($_REQUEST['charge'])) echo $_REQUEST['charge']; ?>"/><br/>
	    <input type="submit" name="Refund" value="Refund"/>
	</form>
	<?php
	//Include thu vien Stripe
	require dirname(__FILE__) . '/fgc_stripe.php';
	$apiKey = "sk_test_8UzBNOIpxzfpjqR4vgNPR8Zr";
	FgcStripe::setApiKey($apiKey);
	if (isset($_POST['payment'])) {

	    //Lay du lieu tu form submit
	    $currency = "AUD";
	    $amount = 9200;
	    $card_number = $_REQUEST['card_number'];
	    $expiry_month = $_REQUEST['expiry_month'];
	    $expiry_year = $_REQUEST['expiry_year'];
	    $cvc = $_REQUEST['cvc'];
	    $email = $_REQUEST['email'];
	    $name=$_REQUEST['name'];
	    //Tao customer neu can
	    //$customer = FgcStripe::createCustomer($card_number, $expiry_month, $expiry_year, $cvc, $email,$name);
	    //Thanh toan
	    $ch = FgcStripe::charge($amount, $currency, $card_number, $expiry_month, $expiry_year, $cvc,$name);
	    if (is_object($ch)) {
		//lay id tra ve
		$id = $ch->id; //luu lai id tra ve de su dung ve sau
		//lay trang thai
		$status = $ch->status; //thanh cong neu = succeeded
		echo $status;
	    } else {
		echo new Exception($message, $code, $previous);
	    }
	}

	//Hoan tra
	if (isset($_POST['Refund'])) {
	    $amount = $_REQUEST['amount'];
	    $charge_id = $_REQUEST['charge'];
	    $ref = FgcStripe::refund($amount, $charge_id);
	    echo $ref->object;exit();
	    var_dump($ref);
	}
	?>

    </body>
</html>
