<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'sha.class.php';


        $data = array();

        $data['orderid'] = 'chien_' . time();
        $data['pspid'] = 'lexuanchien';
        $data['currency'] = 'USD';

        $data['language'] = 'en_US';

        $data['amount'] = (string) (123 * 100);

        // Customer info
        $data['cn'] = 'le xuan chien';
        $data['email'] = 'lexuanchiendhv@gmail.com';
        $data['owneraddress'] = 'thanh phong thanh chuong nghe an';
        $data['ownerzip'] = '1234';
        $data['ownertown'] = 'Vinh';
        $data['ownercty'] = 'vinh';
        $data['ownertelno'] = '0986478150';
        $data['title'] = 'test phuong thuc thanh toan';

        // Appearance on Ogone payment page
        $data['bgcolor'] = '#384A89';
        $data['txtcolor'] = '#CAE7F7';
        $data['tblbgcolor'] = '#CAE7F7';
        $data['tbltxtcolor'] = '#000000';
        $data['buttonbgcolor'] = '#5A77BA';
        $data['buttontxtcolor'] = '#CAE7F7';
        $data['fonttype'] = 'Verdana';

        // Sales or Authorization
        $data['operation'] = '';

        // When the payment is captured, authorized or pending (STATUS 5, 51, 9 and 91)
        // the accept url is called by Ogone.
        $data['accepturl'] = 'http://testdrupal.byethost7.com/ogone_payment/accepturl.php';

        // The cancel, decline and exception url are all called in case of error conditions
        // during the payment.
        $data['cancelurl'] = 'http://testdrupal.byethost7.com/ogone_payment/cancelurl.php';
        $data['declineurl'] = 'http://testdrupal.byethost7.com/ogone_payment/declineurl.php';
        $data['exceptionurl'] = 'http://testdrupal.byethost7.com/ogone_payment/exceptionurl.php';

        // On the Ogone page, these links are used when clicking on the Home or Catolog
        // buttons.
        $data['homeurl'] = 'http://testdrupal.byethost7.com/ogone_payment/';
        $data['catalogurl'] = 'http://testdrupal.byethost7.com/ogone_payment/';
        $data['shasign'] = sha($data, 'in');
        ?>
        <form method="post" action="https://secure.ogone.com/ncol/test/orderstandard.asp" id=form1
              name=form1>
            <!-- general parameters -->
            <?php foreach ($data as $key => $value) { ?>
                <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
            <?php } ?>
            <input type="submit" value="Payment" id="submit2" name="submit2">
        </form>
    </body>
</html>
