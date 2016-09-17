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
        <?php
        require_once dirname(__FILE__) . '/lib/Braintree.php';

        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('r6fnsjyvrqc9wxgb');
        Braintree_Configuration::publicKey('633nddj5gc8v5sjt');
        Braintree_Configuration::privateKey('92ea10f3df0a41beb8e1520d3f354954');

        $result = Braintree_Transaction::sale(array(
                    'amount' => '1000.00',
                    'creditCard' => array(
                        'number' => '4111111111111111',
                        'expirationMonth' => '05',
                        'expirationYear' => '12'
                    )
        ));

        if ($result->success) {
            print_r("success!: " . $result->transaction->id);
        } else if ($result->transaction) {
            print_r("Error processing transaction:");
            print_r("\n  message: " . $result->message);
            print_r("\n  code: " . $result->transaction->processorResponseCode);
            print_r("\n  text: " . $result->transaction->processorResponseText);
        } else {
            print_r("Message: " . $result->message);
            print_r("\nValidation errors: \n");
            print_r($result->errors->deepAll());
        }
        ?>
    </body>
</html>
