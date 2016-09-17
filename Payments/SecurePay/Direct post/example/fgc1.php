<?php
$time = gmdate("YmdHis");
?>
<form name="input" action="https://api.securepay.com.au/live/directpost/authorise" method="post">
    <input type="hidden" name="EPS_MERCHANT" value="ISR0009">
    <input type="hidden" name="EPS_TXNTYPE" value="0">
    <input type="hidden" name="EPS_REFERENCEID" value="1">
    <input type="hidden" name="EPS_AMOUNT" value="1.08">
    <input type="hidden" name="EPS_REDIRECT" value="TRUE">
    <input type="hidden" name="EPS_TIMESTAMP" value="<?php echo $time; ?>">
    <input type="hidden" name="EPS_FINGERPRINT" value="<?php echo sha1('ISR0009|abc123|0|1|1.08|' . $time) ?>">
    <input type="hidden" name="EPS_RESULTURL"  value="https://www.inkstar.com.au/fgc2.php"/>

    <input type="text" name="EPS_CARDNUMBER" value="4444333322221111" id="EPS_CARDNUMBER" placeholder="card number" class="cardnumber"/>
    <input type="text" name="EPS_EXPIRYMONTH" value="12" id="EPS_EXPIRYMONTH" placeholder="mm" class="month"/>
    <input type="text" name="EPS_EXPIRYYEAR" value="17" id="EPS_EXPIRYYEAR" placeholder="yyyy" class="year"/>
    <input type="text" name="EPS_CCV" id="EPS_CCV" value="123" placeholder="cvv"/>
    <input type="submit" name="submit" id="submit" class="submitBtn">
</form>