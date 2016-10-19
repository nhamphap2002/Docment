<?php

/* 
    Created on : Oct 12, 2016, 2:56:56 PM
    Author: Tran Trong Thang
    Email: trantrongthang1207@gmail.com
    Skype: trantrongthang1207
*/


/*
  add_action('init', 'tv_override_billing_fields', 30);
  add_filter('woocommerce_billing_fields', 'tv_override_billing_fields');

  function tv_override_billing_fields($fields) {
  $fields['billing_email'] = array(
  'label' => __('Email', 'woocommerce'),
  'placeholder' => _x('Email', 'placeholder', 'woocommerce'),
  'required' => true,
  'class' => array('form-row-wide tvphone'),
  );
  return $fields;
  }


  add_action('init', 'custom_show_invoice_template_company_logo', 10);

  function custom_show_invoice_template_company_logo() {

  remove_action('yith_ywpi_invoice_template_company_logo', 'show_invoice_template_company_logo', 10);
  add_action('yith_ywpi_invoice_template_company_logo', 'tvshow_invoice_template_company_logo', 10);
  }

  function tvshow_invoice_template_company_logo($document) {

  $company_logo = null;

  if (( $document instanceof YITH_Pro_Forma ) || ( $document instanceof YITH_Invoice )) {
  $company_logo = 'yes' === ywpi_get_option('ywpi_show_company_logo', $document) ? ywpi_get_option('ywpi_company_logo', $document) : null;
  } elseif ($document instanceof YITH_Shipping) {
  $company_logo = 'yes' === ywpi_get_option('ywpi_shipping_list_show_company_logo', $document) ? ywpi_get_option('ywpi_company_logo', $document) : null;
  }

  if ($company_logo) {

  echo
  '<div style=" text-align:left;height:98px;">
  <img src="' . $company_logo . '">test
  </div>';
  }

  }
 */
add_action('init', 'custom_add_style_files', 10);

function custom_add_style_files() {

    remove_action('yith_ywpi_invoice_template_head', 'add_style_files', 10);
    add_action('yith_ywpi_invoice_template_head', 'tvadd_style_files', 10);
}

function tvadd_style_files($document) {
    ob_start();
    wc_get_template('invoice/ywpi-invoice-style.css', null, '', YITH_YWPI_TEMPLATE_DIR);
    wc_get_template('tvstyle.css', null, '', get_template_directory() . '-child/css/');

    $content = ob_get_contents();
    ob_end_clean();
    if ($content) {
        ?>
        <style type="text/css">
        <?php echo $content; ?>
        </style>
        <?php
    }
}

function thachpham_change_copyright($output) {
    $html = '';

    $html = '<footer>
                <div clas="No42-23-600-brown" style="text-align:left; color:#c8978e">FreziaHome - Frezia Pty Ltd </div>
                <div class="No15-15-400-gray"  style="text-align:left;">BG175208653 Moskovska str. 21 Sofia, Bulgaria +18553739435</div>
            </footer>';
    return $html;
}

add_filter('print_document_footer', 'thachpham_change_copyright');