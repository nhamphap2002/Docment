<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './config.php';
include_once './targetpay.class.php';
$targetPay = new TargetPayCore("IDE", IDEAL_RTLO, "e59dbd219e068daade7139be42c5dfd5", "nl", false);
$bankList = $targetPay->getBankList();
echo '<h1>Test phuong thuc thanh toan Targetpay Ideal</h1>';
?>
<div class = "content" id = "payment">
    <table class = "form">
        <tr>
            <td height = 10></td>
        </tr>
        <tr>
            <td>Select bank</td>
            <td><select name="bank_id">
                    <?php
                    foreach ($bankList as $id => $name) {
                        echo "<option value=\"" . $id . "\">" . $name . "</option>\r\n";
                    }
                    ?>
                </select></td>
        </tr>
    </table>
</div>
<div class="buttons">
    <div class="right">
        <input type="hidden" name="custom" value="<?php echo '1'; //chinh la orderID        ?>" />   
        <input type="button" value="Process" id="button-confirm" class="button" />
    </div>
</div>
<script type="text/javascript" src="<?php echo SITE . 'jquery.js'; ?>"></script>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
        $.ajax({
            url: '<?php echo SITE . 'send.php'; ?>',
            type: 'post',
            data: $('#payment :input'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-confirm').attr('disabled', true);
                $('#payment').before('<div class="attention">Loading...</div>');
            },
            complete: function() {
                $('#button-confirm').attr('disabled', false);
                $('.attention').remove();
            },
            success: function(json) {
                if (json['error']) {
                    alert(json['error']);
                }

                if (json['success']) {
                    location = json['success'];
                }
            }
        });
    });
//--></script> 