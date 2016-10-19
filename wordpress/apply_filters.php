<?php

/* 
    Created on : Oct 12, 2016, 2:48:58 PM
    Author: Tran Trong Thang
    Email: trantrongthang1207@gmail.com
    Skype: trantrongthang1207
*/


function footer_invoice($output) {
    $html = '';

    $html = '<footer>
                <div clas="No42-23-600-brown" style="text-align:left; color:#c8978e">FreziaHome - Frezia Pty Ltd </div>
                <div class="No15-15-400-gray"  style="text-align:left;">ABN 71 605 556 527, 17A Manallack Street, Brunswick, VIC 3056, Australia</div>
            </footer>';
    return $html;
}

add_filter('print_document_footer', 'footer_invoice');
