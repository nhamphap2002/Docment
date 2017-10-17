
/*
 * Created on : Oct 17, 2017, 8:44:11 AM
 * Author: Tran Trong Thang
 * Email: trantrongthang1207@gmail.com
 * Skype: trantrongthang1207
 */
jQuery(document).ready(function ($) {
    jQuery('body').on('click', '.woocommerce-checkout-nav a, .continue-checkout', function (e) {

        if (!$('#billing_phone').val()) {
            $('#billing_phone').css('border', '1px solid red');
            $('#billing_phone').parent().addClass('woocommerce-invalid');
        } else {
            $('#billing_phone').css('border', '1px solid #d2d2d2');
        }
    })
    $('body').on('update_checkout', function (){
        $('#billing_phone_field').addClass('validate-required');
    });
})
