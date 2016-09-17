<?php

/**
 * Lớp thực hiện tạo các hàm xử lý phục vụ cho cổng thanh toán POLI
 *
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
class POLI {

    /**
     * Hàm thực hiện gửi request băng Curl
     * @param type $url
     * @param type $xml_builder
     * @return type
     */
    public function sendRequest($url, $xml_builder) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:  text/xml'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_builder);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        $referrer = "";
        curl_setopt($ch, CURLOPT_REFERER, $referrer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * Hàm thực hiện tạo Xml phục vụ cho Request Callback
     * @param type $params
     */
    public function xmlBuilderForCallback($params = array()) {
        $xml_builder = '<?xml version="1.0" encoding="utf-8"?>
<GetTransactionRequest
xmlns="http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.Contracts" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
<AuthenticationCode>' . $params['authenticationcode'] . '</AuthenticationCode>
<MerchantCode>' . $params['merchantcode'] . '</MerchantCode>
<TransactionToken>' . $params['token'] . '</TransactionToken>
</GetTransactionRequest>';
        return $xml_builder;
    }

    /**
     * Hàm thực hiện tạo Xml phục vụ cho Request lấy Redirect
     * @param type $params
     */
    public function xmlBuilderForRedirect($params = array()) {
        $xml_builder = '<?xml version="1.0" encoding="utf-8"?>
<InitiateTransactionRequest
xmlns="http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.Contracts"
xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<AuthenticationCode>' . $params['authenticationcode'] . '</AuthenticationCode>
	<Transaction xmlns:dco="http://schemas.datacontract.org/2004/07/Centricom.POLi.Services.MerchantAPI.DCO">
		<dco:CurrencyAmount>' . $params['amount'] . '</dco:CurrencyAmount>
		<dco:CurrencyCode>' . $params['pcurrency'] . '</dco:CurrencyCode>
		<dco:MerchantCheckoutURL>' . $params['actuallink'] . '</dco:MerchantCheckoutURL>
		<dco:MerchantCode>' . $params['merchantcode'] . '</dco:MerchantCode>
		<dco:MerchantData>' . $params['order_status'] . '</dco:MerchantData>
		<dco:MerchantDateTime>' . $params['datetime'] . '</dco:MerchantDateTime>
		<dco:MerchantHomePageURL>' . $params['baselink'] . '</dco:MerchantHomePageURL>
		<dco:MerchantRef>' . $params['merchantdata'] . '</dco:MerchantRef>
		<dco:MerchantReferenceFormat>0</dco:MerchantReferenceFormat>
		<dco:NotificationURL>' . $params['nudge'] . '</dco:NotificationURL>
		<dco:SelectedFICode i:nil="true" />
		<dco:SuccessfulURL>' . $params['success'] . '</dco:SuccessfulURL>
		<dco:Timeout>0</dco:Timeout>
		<dco:UnsuccessfulURL>' . $params['cancel'] . '</dco:UnsuccessfulURL>
		<dco:UserIPAddress>' . $params['ipaddress'] . '</dco:UserIPAddress>
  </Transaction>
</InitiateTransactionRequest>';
        return $xml_builder;
    }

    /**
     * Hàm thực hiện tạo Form để submit dữ liệu lên POLI
     * @param type $datas
     */
    public function formBuilder($datas = array()) {
        ob_start();
        ?>
        <div>
            <a href="http://www.polipayments.com/" target="_blank">
                <img src="<?php echo $datas['poli_logo']; ?>" alt="POLi Payments">
            </a>
            <form action="<?php echo $datas['action']; ?>" method="post">

                <input type="hidden" name="recipient_description" value="<?php echo $datas['description']; ?>" />
                <input type="hidden" name="transaction_id" value="<?php echo $datas['transaction_id']; ?>" />
                <input type="hidden" name="return_url" value="<?php echo $datas['return_url']; ?>" />
                <input type="hidden" name="cancel_url" value="<?php echo $datas['cancel_url']; ?>" />
                <input type="hidden" name="status_url" value="<?php echo $datas['status_url'];  ?>" />
                <input type="hidden" name="language" value="<?php echo $datas['language']; ?>" />
                <input type="hidden" name="logo_url" value="<?php echo $datas['logo']; ?>" />
                <input type="hidden" name="pay_from_email" value="<?php echo $datas['pay_from_email']; ?>" />
                <input type="hidden" name="firstname" value="<?php echo $datas['firstname']; ?>" />
                <input type="hidden" name="lastname" value="<?php echo $datas['lastname']; ?>" />
                <input type="hidden" name="address" value="<?php echo $datas['address']; ?>" />
                <input type="hidden" name="address2" value="<?php echo $datas['address2']; ?>" />
                <input type="hidden" name="phone_number" value="<?php echo $datas['phone_number']; ?>" />
                <input type="hidden" name="postal_code" value="<?php echo $datas['postal_code']; ?>" />
                <input type="hidden" name="city" value="<?php echo $datas['city']; ?>" />
                <input type="hidden" name="state" value="<?php echo $datas['state']; ?>" />
                <input type="hidden" name="country" value="<?php echo $datas['country']; ?>" />
                <input type="hidden" name="amount" value="<?php echo $datas['amount']; ?>" />
                <input type="hidden" name="currency" value="<?php echo $datas['currency']; ?>" />
                <input type="hidden" name="detail1_text" value="<?php echo $datas['detail1_text']; ?>" />
                <input type="hidden" name="merchant_fields" value="order_id" />
                <input type="hidden" name="order_id" value="<?php echo $datas['order_id']; ?>" />
                <input type="hidden" name="platform" value="<?php echo $datas['platform']; ?>" />
                <div class="buttons">
                    <div class="right">
                        <input type="submit" value="<?php echo $datas['button_confirm']; ?>" class="button" />
                    </div>
                    <div class="left">
                        <a href="https://transaction.apac.paywithpoli.com/POLiFISupported.aspx?merchantcode=<?php echo $datas['merchantcode']; ?>" target="_blank">Available Banks</a>
                    </div>
                </div>
            </form>
        </div>
        <?php
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

}
?>
