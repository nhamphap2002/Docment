    <form method=POST action="https://www.sandbox.paypal.com/cgi-bin/webscr" name="formOrder" id="formOrder">
    <input type="hidden" name="charset" value="utf-8" />
    <input type="hidden" name="business" value="chien.lexuan-facilitator@gmail.com" />
    <input type="hidden" name="return" value="http://www.lexuanchien.byethost7.com/testpaypal/return.php" />
    <input type="hidden" name="cancel_return" value="http://www.lexuanchien.byethost7.com/testpaypal/cancel.php" />
    <input type="hidden" name="notify_url" value="http://www.lexuanchien.byethost7.com/testpaypal/notify.php" />

    <input type="hidden" name="currency_code" value="USD" />
    <input type="hidden" name="cmd" value="_xclick" />
    <input type="hidden" name="amount" value="67.65" />
    gia cua don hang la 67.65 USD<br>


    <input type="hidden" name="tax_cart" value="0.00" /><input type="submit" name="Submit" id="Submit" value="Confirm Order"></form>   
