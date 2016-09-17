<?php

// Require TCPDF
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// Connect to DB
$db = '2014_jason13_plugin_development';
$un = 'root';
$pw = '123456';
$con = mysqli_connect("localhost", $un, $pw, $db);

// Check connection
if (mysqli_connect_errno($con)) {
    echo mysqli_connect_error();
}

// Build gift voucher key
function buildKey() {

    $howmany = '17';
    $key = '';

    for ($i = 1; $i < $howmany; $i++) {
        $randval = rand(97, 122);
        $key .= chr($randval);

        if ($i % 4 == 0 && $i != 16) {
            $key .= '-';
        }
    }

    $key = strtoupper($key);

    return $key;
}

// Add order to database
function addOrder($data) {

    global $con;

    $queue['coupon'] = buildKey();

    $data = $queue + $data;

    foreach ($data as $col => $val) {
        $cols .= $col . ", ";
        $val = mysqli_real_escape_string($con, $val);
        $vals .= "'" . $val . "', ";
    }
    $cols = substr($cols, 0, -2);
    $vals = substr($vals, 0, -2);

    $query = "INSERT INTO orders (" . $cols . ") VALUES (" . $vals . ")";

    if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
    } else {

        $query = "SELECT id FROM orders WHERE coupon = '" . $data['coupon'] . "'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        header('Location: /gift-vouchers/controller.php?task=confirm_order&id=' . $row['id']);
    }
}

// Cancel order
function cancelOrder($id) {

    global $con;

    $query = "DELETE FROM orders WHERE id = $id";

    if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
    } else {

        header('Location: /gift-vouchers.php');
    }
}

// Build PayPal request
function confirmOrder($id) {

    global $con;

//le xuan chien
    $paypal_email = 'chien.lexuan@gmail.com';
//$paypal_email="marketing@diamondskinclinic.com.au";
    $action = "https://securepayments.sandbox.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess";
//$action="https://securepayments.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess";
//end


    $paypal_item_name = 'Diamond Skin Clinic Gift Voucher';

    $html = '';

    $query = "SELECT * FROM orders WHERE id = " . $id;

    if ($result = mysqli_query($con, $query)) {

        $row = mysqli_fetch_array($result);

        $html .= "<p><strong>Purchase Amount:</strong> $" . $row['voucher_amount'] . "</p>";

        $html .= '<form action="' . $action . '" method="post">
		
						<input type="hidden" name="buyer_email" value="' . $row['sender_email'] . '">
						<input type="hidden" name="first_name" value="' . $row['sender_first_name'] . '">
						<input type="hidden" name="last_name" value="' . $row['sender_surname'] . '">
						
						<input type="hidden" name="invoice" value="' . $row['id'] . '">
						<input type="hidden" name="item_name" value="' . $paypal_item_name . '">

						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="subtotal" value="' . $row['voucher_amount'] . '">
						
						<input type="hidden" name="business" value="' . $paypal_email . '">
						<input type="hidden" name="paymentaction" value="sale">
						<input type="hidden" name="currency_code" value="AUD">
						<input type="hidden" name="no_shipping" value="1">
						
						<input type="hidden" name="notify_url" value="http://www.diamondskinclinic.com.au/gift-vouchers/controller.php?task=verify_ipn">
						<input type="hidden" name="return" value="http://www.diamondskinclinic.com.au/">
						<input type="hidden" name="cancel_return" value="http://www.diamondskinclinic.com.au/gift-vouchers/controller.php?task=cancel_order&id=' . $row['id'] . '">
						
						<input type="submit" name="METHOD" value="Pay now with PayPal >>">
						<input type="button" name="CANCEL" value="Cancel" onclick="document.location.href=\'gift-vouchers/controller.php?task=cancel_order&id=' . $row['id'] . '\';">
						
					</form>';

        mysqli_free_result($result);
    }

    echo $html;
}

// IPN
function readIPN() {

    // STEP 1: Read POST data
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

    $req = 'cmd=_notify-validate';
    if (function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }


    // STEP 2: Post IPN data back to paypal to validate
    //le xuan chien
//$veryfy_ipn="https://www.sandbox.paypal.com/cgi-bin/webscr";
    $veryfy_ipn = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($veryfy_ipn);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

    if (!($res = curl_exec($ch))) {
        curl_close($ch);
        exit;
    }
    curl_close($ch);


    // STEP 3: Inspect IPN validation result and act accordingly
    if (strcmp($res, "VERIFIED") == 0) {
        // check whether the payment_status is Completed
        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process payment
        // assign posted variables to local variables
        $invoice = $_POST['invoice'];
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];

        setOrderStatus(1, $invoice);
    } else if (strcmp($res, "INVALID") == 0) {
        echo 'Payment not received.';
    }
}

// Mark order as paid
function setOrderStatus($status, $id) {

    global $con;

    $query = "UPDATE orders SET ipn_status = " . $status . " WHERE id = " . $id;

    if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
    } else {
        createPDF($id);
    }
}

// Create PDF
function createPDF($id) {

    global $con;

    $query = "SELECT * FROM orders WHERE id = " . $id;

    $result = mysqli_query($con, $query);

    if (isset($id)) {
        $check_voucher = mysqli_num_rows($result);
    } else {
        $check_voucher = 0;
    }
    if ($check_voucher > 0) {

        $row = mysqli_fetch_array($result);

        $data['id'] = $row['id'];
        $data['coupon'] = $row['coupon'];
        $data['voucher_name'] = $row['voucher_name'];
        $data['voucher_amount'] = $row['voucher_amount'];
        $data['date'] = date('d-m-Y', strtotime($row['date']));

        mysqli_free_result($result);

        // create new PDF document
        $width = 210;
        $height = 99;
        $pagelayout = array($height, $width);
        $pdf = new TCPDF('l', PDF_UNIT, $pagelayout, true, 'UTF-8', false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set auto page breaks
        $pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(1);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('helvetica', '', 12);

        $pdf->AddPage();

        $pdf->ImageEps($file = 'gift-voucher.ai', $x = 0, $y = 0, $w = 210, $h = 99, $link = '', $useBoundingBox = true, $align = '', $palign = '', $border = 0, $fitonpage = false);

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
        // Recipient Name
        $pdf->MultiCell(160, 10, $data['voucher_name'], 0, 'L', 0, 0, 32, 47, true);
        // Amount
        $pdf->MultiCell(50, 10, '$' . $data['voucher_amount'], 0, 'L', 0, 0, 29, 78.5, true);
        // Key
        $pdf->MultiCell(160, 10, $data['coupon'], 0, 'L', 0, 0, 82, 78.5, true);
        // Date
        $pdf->MultiCell(160, 10, $data['date'], 0, 'L', 0, 0, 166.5, 78.5, true);

        // ---------------------------------------------------------
        //Close and output PDF document
        $tmp_dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        $pdf_path = 'voucher-store/Diamond Skin Clinic Gift Voucher - ' . $data['id'] . '.pdf';
        // echo $pdf_path;
        $pdf->Output($pdf_path, 'F');

        sendVoucher($data['id']);
    } else {
        echo 'Could not find Voucher';
    }
}

// Send Voucher
function sendVoucher($id) {

    require_once('swiftmail/lib/swift_required.php');

    global $con;

    $query = "SELECT * FROM orders WHERE id = " . $id;

    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_array($result);

    $mailto = $row['sender_email'];
    $to = $row['sender_first_name'] . ' ' . $row['sender_surname'];
    $from_mail = 'info@diamondskinclinic.com.au';
    $from_name = 'Diamond Skin Clinic';
    $replyto = 'info@diamondskinclinic.com.au';
    $message = 'Please find attached your Diamond Skin Clinic Gift Voucher!';

    $file = 'voucher-store/Diamond Skin Clinic Gift Voucher - ' . $row['id'] . '.pdf';

    // Create the Transport
    $transport = Swift_MailTransport::newInstance();

    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Message to Customer
    $body = '<style>p { font-family: Arial, Helvetica, sans-serif; color: #333; font-size: 12px; }</style>
				<p><img src="http://diamondskinclinic.com.au/images/main_logo.gif" /></p>
				<table cellpadding="25">
					<tr>
						<td>
						<p>Hello ' . $row['sender_first_name'] . ',</p>
						<p>Thank you for your purchase. Please print the attached gift voucher and present it to Diamond Skin Clinic.</p>
						<p>Voucher Name: <strong>' . $row['voucher_name'] . '</strong></p>
						<p>Amount: <strong>$' . $row['voucher_amount'] . '</strong></p>
						<p>Date: <strong>' . date('d-m-Y', strtotime($row['date'])) . '</strong></p>
						<p>Coupon: <strong>' . $row['coupon'] . '</strong></p>
						</td>
					</tr>
				</table>';
    $subject = 'Your Gift Voucher';

    $message = Swift_Message::newInstance($subject)
            ->setFrom(array($from_mail => 'Diamond Skin Clinic'))
            ->setTo(array($mailto => $to))
            ->setBody($body, 'text/html');
    $message->attach(Swift_Attachment::fromPath($file));

    $email = $mailer->send($message);

    // Message to Diamon Skin Clinic
    $body = '<style>p { font-family: Arial, Helvetica, sans-serif; color: #333; font-size: 12px; }</style>
				<p><img src="http://diamondskinclinic.com.au/images/main_logo.gif" /></p>
				<table cellpadding="25">
					<tr>
						<td>
						<p>Hello Diamond Skin Clinic,</p>
						<p>An order has been placed and confirmed for a Diamond Skin Clinic Gift Voucher.</p>
						<p>Customer Name: <strong>' . $row['sender_first_name'] . ' ' . $row['sender_surname'] . '</strong></p>
						<p>Voucher Name: <strong>' . $row['voucher_name'] . '</strong></p>
						<p>Amount: <strong>$' . $row['voucher_amount'] . '</strong></p>
						<p>Date: <strong>' . date('d-m-Y', strtotime($row['date'])) . '</strong></p>
						<p>Coupon: <strong>' . $row['coupon'] . '</strong></p>
						</td>
					</tr>
				</table>';

    $subject = 'Gift Voucher Order';

    $message = Swift_Message::newInstance($subject)
            ->setFrom(array($from_mail => 'Diamond Skin Clinic'))
            ->setTo(array('info@diamondskinclinic.com.au' => 'Diamond Skin Clinic'))
            ->setBody($body, 'text/html');
    $message->attach(Swift_Attachment::fromPath($file));

    $email = $mailer->send($message);

    mysqli_free_result($result);
}

?>