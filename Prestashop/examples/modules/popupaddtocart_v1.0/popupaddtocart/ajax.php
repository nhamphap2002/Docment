<?php

ob_start();
?>
<script src="http://localhost/prestashop/prestashop_156/modules/blockcart/pproduct.js" type="text/javascript"></script>
<script type="text/javascript">
    var currencySign = '$';
    var currencyRate = '1';
    var currencyFormat = '1';
    var currencyBlank = '0';
    var taxRate = 0;
// Parameters
    var id_product = '1';
    var arrproductHasAttributes = new Array();
    arrproductHasAttributes['p_1'] = true;

    var arrquantitiesDisplayAllowed = new Array();
    arrquantitiesDisplayAllowed['p_1'] = true;

    var arrquantityAvailable = new Array();
    arrquantityAvailable['p_1'] = 1600;

    var arrallowBuyWhenOutOfStock = new Array();
    arrallowBuyWhenOutOfStock['p_1'] = false;

    var arravailableNowValue = new Array();
    arravailableNowValue['p_1'] = 'In stock';

    var arravailableLaterValue = new Array();
    arravailableLaterValue['p_1'] = '';

    var arrproductPriceTaxExcluded = new Array();
    arrproductPriceTaxExcluded['p_1'] = 124.58194 - 0.000000;

    var arrproductBasePriceTaxExcluded = new Array();
    arrproductBasePriceTaxExcluded['p_1'] = 124.581940 - 0.000000;

    var arrreduction_percent = new Array();
    arrreduction_percent['p_1'] = 5;

    var arrreduction_price = new Array();
    arrreduction_price['p_1'] = 0;

    var arrspecific_price = new Array();
    arrspecific_price['p_1'] = -1.000000;

    var arrproduct_specific_price = new Array();
    arrproduct_specific_price['p_1'] = new Array();
    arrproduct_specific_price['p_1']['id_specific_price'] = '1';
    arrproduct_specific_price['p_1']['id_specific_price_rule'] = '0';
    arrproduct_specific_price['p_1']['id_cart'] = '0';
    arrproduct_specific_price['p_1']['id_product'] = '1';
    arrproduct_specific_price['p_1']['id_shop'] = '0';
    arrproduct_specific_price['p_1']['id_shop_group'] = '0';
    arrproduct_specific_price['p_1']['id_currency'] = '0';
    arrproduct_specific_price['p_1']['id_country'] = '0';
    arrproduct_specific_price['p_1']['id_group'] = '0';
    arrproduct_specific_price['p_1']['id_customer'] = '0';
    arrproduct_specific_price['p_1']['id_product_attribute'] = '0';
    arrproduct_specific_price['p_1']['price'] = '-1.000000';
    arrproduct_specific_price['p_1']['from_quantity'] = '1';
    arrproduct_specific_price['p_1']['reduction'] = '0.050000';
    arrproduct_specific_price['p_1']['reduction_type'] = 'percentage';
    arrproduct_specific_price['p_1']['from'] = '0000-00-00 00:00:00';
    arrproduct_specific_price['p_1']['to'] = '0000-00-00 00:00:00';
    arrproduct_specific_price['p_1']['score'] = '32';

    var arrspecific_currency = new Array();
    arrspecific_currency['p_1'] = false;

    var arrgroup_reduction = new Array();
    arrgroup_reduction['p_1'] = '1';

    var arrdefault_eco_tax = new Array();
    arrdefault_eco_tax['p_1'] = 0.000000;

    var arrecotaxTax_rate = new Array();
    arrecotaxTax_rate['p_1'] = 0;

    var arrcurrentDate = new Array();
    arrcurrentDate['p_1'] = '2014-02-09 21:08:42';

    var arrmaxQuantityToAllowDisplayOfLastQuantityMessage = new Array();
    arrmaxQuantityToAllowDisplayOfLastQuantityMessage['p_1'] = 3;

    var arrnoTaxForThisProduct = new Array();
    arrnoTaxForThisProduct['p_1'] = true;

    var arrdisplayPrice = new Array();
    arrdisplayPrice['p_1'] = 1;

    var arrproductReference = new Array();
    arrproductReference['p_1'] = 'demo_1';

    var arrproductAvailableForOrder = new Array();
    arrproductAvailableForOrder['p_1'] = '1';

    var arrproductShowPrice = new Array();
    arrproductShowPrice['p_1'] = '1';

    var arrproductUnitPriceRatio = new Array();
    arrproductUnitPriceRatio['p_1'] = '0.000000';

    var arridDefaultImage = new Array();
    arridDefaultImage['p_1'] = 15;

    var arrstock_management = new Array();
    arrstock_management['p_1'] = 1;

    var arrproductPriceWithoutReduction = new Array();
    arrproductPriceWithoutReduction['p_1'] = '166.38796';

    var arrproductPrice = new Array();
    arrproductPrice['p_1'] = '158.07';


// Translations
    var doesntExist = 'This combination does not exist for this product. Please select another combination.';
    var doesntExistNoMore = 'This product is no longer in stock';
    var doesntExistNoMoreBut = 'with those attributes but is available with others.';
    var uploading_in_progress = 'Uploading in progress, please be patient.';
    var fieldRequired = 'Please fill in all the required fields before saving your customization.';


// Combinations
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(33, new Array('15', '14'), 100, 41.80602, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(32, new Array('15', '7'), 100, 41.80602, 0, 18, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(31, new Array('15', '6'), 100, 41.80602, 0, 17, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(30, new Array('15', '5'), 100, 41.80602, 0, 19, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(29, new Array('15', '4'), 100, 41.80602, 0, 16, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(35, new Array('15', '19'), 100, 41.80602, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(28, new Array('15', '3'), 100, 41.80602, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(34, new Array('15', '18'), 100, 41.80602, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(40, new Array('16', '7'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(39, new Array('16', '6'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(38, new Array('16', '5'), 100, 83.61204, 0, 19, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(37, new Array('16', '4'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(43, new Array('16', '19'), 100, 83.61204, 0, 22, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(36, new Array('16', '3'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(42, new Array('16', '18'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 5;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = -1.000000;
    specific_price_combination['reduction_type'] = 'percentage';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(41, new Array('16', '14'), 100, 83.61204, 0, -1, 'demo_1', 0.00, 1, available_date, specific_price_combination);

    arrproductHasAttributes['p_2'] = true;

    arrquantitiesDisplayAllowed['p_2'] = true;

    arrquantityAvailable['p_2'] = 301;

    arrallowBuyWhenOutOfStock['p_2'] = false;

    arravailableNowValue['p_2'] = 'In stock';

    arravailableLaterValue['p_2'] = '';

    arrproductPriceTaxExcluded['p_2'] = 66.0535 - 0.000000;

    arrproductBasePriceTaxExcluded['p_2'] = 66.053500 - 0.000000;

    arrreduction_percent['p_2'] = 5;

    arrreduction_price['p_2'] = 0;

    arrspecific_price['p_2'] = -1.000000;

    arrproduct_specific_price['p_2'] = new Array();
    arrproduct_specific_price['p_2']['id_specific_price'] = '1';
    arrproduct_specific_price['p_2']['id_specific_price_rule'] = '0';
    arrproduct_specific_price['p_2']['id_cart'] = '0';
    arrproduct_specific_price['p_2']['id_product'] = '1';
    arrproduct_specific_price['p_2']['id_shop'] = '0';
    arrproduct_specific_price['p_2']['id_shop_group'] = '0';
    arrproduct_specific_price['p_2']['id_currency'] = '0';
    arrproduct_specific_price['p_2']['id_country'] = '0';
    arrproduct_specific_price['p_2']['id_group'] = '0';
    arrproduct_specific_price['p_2']['id_customer'] = '0';
    arrproduct_specific_price['p_2']['id_product_attribute'] = '0';
    arrproduct_specific_price['p_2']['price'] = '-1.000000';
    arrproduct_specific_price['p_2']['from_quantity'] = '1';
    arrproduct_specific_price['p_2']['reduction'] = '0.050000';
    arrproduct_specific_price['p_2']['reduction_type'] = 'percentage';
    arrproduct_specific_price['p_2']['from'] = '0000-00-00 00:00:00';
    arrproduct_specific_price['p_2']['to'] = '0000-00-00 00:00:00';
    arrproduct_specific_price['p_2']['score'] = '32';

    arrspecific_currency['p_2'] = false;

    arrgroup_reduction['p_2'] = '1';

    arrdefault_eco_tax['p_2'] = 0.000000;

    arrecotaxTax_rate['p_2'] = 0;

    arrcurrentDate['p_2'] = '2014-02-09 21:08:42';

    arrmaxQuantityToAllowDisplayOfLastQuantityMessage['p_2'] = 3;

    arrnoTaxForThisProduct['p_2'] = true;

    arrdisplayPrice['p_2'] = 1;

    arrproductReference['p_2'] = 'demo_1';

    arrproductAvailableForOrder['p_2'] = '1';

    arrproductShowPrice['p_2'] = '1';

    arrproductUnitPriceRatio['p_2'] = '0.000000';

    arridDefaultImage['p_2'] = 15;

    arrstock_management['p_2'] = 1;

    arrproductPriceWithoutReduction['p_2'] = '66.0535';

    arrproductPrice['p_2'] = '66.05';
// Combinations
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 0;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = 0;
    specific_price_combination['reduction_type'] = '';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(3, new Array('3'), 100, 0, 0, 26, '', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 0;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = 0;
    specific_price_combination['reduction_type'] = '';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(1, new Array('4'), 100, 0, 0, 23, '', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 0;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = 0;
    specific_price_combination['reduction_type'] = '';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(4, new Array('5'), 100, 0, 0, 25, '', 0.00, 1, available_date, specific_price_combination);
    var specific_price_combination = new Array();
    var available_date = new Array();
    specific_price_combination['reduction_percent'] = 0;
    specific_price_combination['reduction_price'] = 0;
    specific_price_combination['price'] = 0;
    specific_price_combination['reduction_type'] = '';
    specific_price_combination['id_product_attribute'] = 0;
    available_date['date'] = '';
    available_date['date_formatted'] = '';
    addCombination(2, new Array('6'), 100, 0, 0, 24, '', 0.00, 1, available_date, specific_price_combination);

</script>
<div class="js-modal-crossselling modal-crossselling">
    <div style="background: #000000; opacity: 0.8;" class="js-modal-crossselling__close modal-crossselling__overlay">
    </div>
    <div style="
         background: #EEEEEE;
         width: 490px;
         padding: 15px;
         margin-left: -260px;
         margin-top: -202.5px;
         " class="modal-crossselling__popin">
        <div style="height: 300px" class="pinner">
            Chung toi han hanh thoi thieu cho cac ban cac san pham lien quan den doi voi san phan nay. 
            <div class="pcol">
                <form action="http://localhost/prestashop/prestashop_156/index.php?controller=cart" method="post">
                    <div id="image-block">
                        <span id="view_full_size">
                            <img id="bigpic" alt="iPod Nano" title="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/5/15-large_default.jpg">
                        </span>
                    </div>
                    <div class="product_attributes">
                        <!-- attributes -->
                        <div id="attributes">
                            <div class="clear"></div>
                            <fieldset class="attribute_fieldset">
                                <label for="group_1" class="attribute_label">Disk space :&nbsp;</label>
                                <div class="attribute_list">
                                    <select onchange="pfindCombination(this);
                                            pgetProductAttribute(this);" class="attribute_select" id="group_1" name="group_1">
                                        <option title="8GB" selected="selected" value="15">8GB</option>
                                        <option title="16GB" value="16">16GB</option>
                                    </select>
                                </div>
                            </fieldset>
                            <fieldset class="attribute_fieldset">
                                <label for="group_2" class="attribute_label">Color :&nbsp;</label>
                                <div class="attribute_list">
                                    <select onchange="pfindCombination(this);
                                            pgetProductAttribute(this);" class="attribute_select" id="group_2" name="group_2">
                                        <option title="Metal" selected="selected" value="3">Metal</option>
                                        <option title="Blue" value="4">Blue</option>
                                        <option title="Pink" value="5">Pink</option>
                                        <option title="Green" value="6">Green</option>
                                        <option title="Orange" value="7">Orange</option>
                                        <option title="Black" value="14">Black</option>
                                        <option title="Purple" value="18">Purple</option>
                                        <option title="Yellow" value="19">Yellow</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <p style="" id="product_reference">
                            <label>Reference </label>
                            <span class="editable">demo_1</span>
                        </p>

                        <!-- quantity wanted -->
                        <p id="quantity_wanted_p">
                            <label>Quantity</label>
                            <input type="text" maxlength="3" size="2" value="1" class="text" id="quantity_wanted" name="qty">
                        </p>

                        <!-- minimal quantity wanted -->
                        <p style="display: none;" id="minimal_quantity_wanted_p">
                            This product is not sold individually. You must select at least <b id="minimal_quantity_label">1</b> quantity for this product.
                        </p>

                        <!-- availability -->
                        <p id="availability_statut">
                            <span id="availability_label">Availability:</span>
                            <span id="availability_value">In stock</span>				
                        </p>
                        <p style="display: none;" id="availability_date">
                            <span id="availability_date_label">Availability date:</span>
                            <span id="availability_date_value">0000-00-00</span>
                        </p>
                        <!-- number of item in stock -->
                        <p id="pQuantityAvailable">
                            <span id="quantityAvailable">100</span>
                            <span id="quantityAvailableTxt" style="display: none;">Item in stock</span>
                            <span id="quantityAvailableTxtMultiple">Items in stock</span>
                        </p>

                        <!-- Out of stock hook -->
                        <div style="display: none;" id="oosHook">

                        </div>

                        <p style="display: none" id="last_quantities" class="warning_inline">Warning: Last items in stock!</p>
                    </div>
                    <input type="hidden" value="1" name="id_product">
                    <input type="hidden" value="1ba86b61130ddaf618439cf8cc8d05ef" name="token">
                    <input id="product_page_product_id" type="hidden" value="1" name="id_product">
                    <input type="hidden" value="1" name="add">
                    <input id="idCombination" type="hidden" value="" name="id_product_attribute">
                    <div class="content_prices clearfix">
                        <!-- prices -->
                        <div class="price">
                            <p class="our_price_display">
                                <span id="our_price_display">$158.07</span>
                                <!---->
                            </p>
                            <span class="discount">Reduced price!</span>
                        </div>
                        <p id="reduction_percent"><span id="reduction_percent_display">-5%</span></p>
                        <p style="display:none" id="reduction_amount">
                            <span id="reduction_amount_display">
                            </span>
                        </p>
                        <p id="old_price">
                            <span id="old_price_display">$166.39</span>
                            <!--  -->
                        </p>
                        <p class="buttons_bottom_block" id="add_to_cart">
                            <span></span>
                            <input type="submit" class="exclusive" value="Add to cart" name="Submit">
                        </p>
                        <div class="clear"></div>
                    </div>
                    <ul id="thumbs_list_frame">
                        <li id="thumbnail_15">
                            <a title="iPod Nano" class="thickbox shown" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/1/5/15-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/5/15-medium_default.jpg" id="thumb_15">
                            </a>
                        </li>
                        <li id="thumbnail_16">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/1/6/16-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/6/16-medium_default.jpg" id="thumb_16">
                            </a>
                        </li>
                        <li id="thumbnail_17">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/1/7/17-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/7/17-medium_default.jpg" id="thumb_17">
                            </a>
                        </li>
                        <li id="thumbnail_18">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/1/8/18-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/8/18-medium_default.jpg" id="thumb_18">
                            </a>
                        </li>
                        <li id="thumbnail_19">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/1/9/19-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/1/9/19-medium_default.jpg" id="thumb_19">
                            </a>
                        </li>
                        <li id="thumbnail_20">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/0/20-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/2/0/20-medium_default.jpg" id="thumb_20">
                            </a>
                        </li>
                        <li id="thumbnail_21">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/1/21-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/2/1/21-medium_default.jpg" id="thumb_21">
                            </a>
                        </li>
                        <li id="thumbnail_22">
                            <a title="iPod Nano" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/2/22-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod Nano" alt="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/2/2/22-medium_default.jpg" id="thumb_22">
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="pcol">
                <form action="http://localhost/prestashop/prestashop_156/index.php?controller=cart" method="post">
                    <div id="image-block">
                        <span id="view_full_size">
                            <img id="bigpic" alt="iPod Nano" title="iPod Nano" src="http://localhost/prestashop/prestashop_156/img/p/2/3/23-large_default.jpg">
                        </span>
                    </div>
                    <div class="product_attributes">
                        <!-- attributes -->
                        <div id="attributes">
                            <div class="clear"></div>
                            <fieldset class="attribute_fieldset">
                                <label for="group_2" class="attribute_label">Color :&nbsp;</label>
                                <div class="attribute_list">
                                    <select onchange="pfindCombination(this);
                                            pgetProductAttribute(this);" class="attribute_select" id="group_2" name="group_2">
                                        <option title="Metal" value="3">Metal</option>
                                        <option title="Blue" value="4">Blue</option>
                                        <option title="Pink" value="5">Pink</option>
                                        <option title="Green" selected="selected" value="6">Green</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <p style="" id="product_reference">
                            <label>Reference </label>
                            <span class="editable">demo_2</span>
                        </p>

                        <!-- quantity wanted -->
                        <p id="quantity_wanted_p">
                            <label>Quantity</label>
                            <input type="text" maxlength="3" size="2" value="1" class="text" id="quantity_wanted" name="qty">
                        </p>

                        <!-- minimal quantity wanted -->
                        <p style="display: none;" id="minimal_quantity_wanted_p">
                            This product is not sold individually. You must select at least <b id="minimal_quantity_label">1</b> quantity for this product.
                        </p>

                        <!-- availability -->
                        <p id="availability_statut">
                            <span id="availability_label">Availability:</span>
                            <span id="availability_value">In stock</span>				
                        </p>
                        <p style="display: none;" id="availability_date">
                            <span id="availability_date_label">Availability date:</span>
                            <span id="availability_date_value">0000-00-00</span>
                        </p>
                        <!-- number of item in stock -->
                        <p id="pQuantityAvailable">
                            <span id="quantityAvailable">100</span>
                            <span id="quantityAvailableTxt" style="display: none;">Item in stock</span>
                            <span id="quantityAvailableTxtMultiple">Items in stock</span>
                        </p>

                        <!-- Out of stock hook -->
                        <div style="display: none;" id="oosHook">

                        </div>

                        <p style="display: none" id="last_quantities" class="warning_inline">Warning: Last items in stock!</p>
                    </div>
                    <input type="hidden" value="1ba86b61130ddaf618439cf8cc8d05ef" name="token">
                    <input type="hidden" id="product_page_product_id" value="2" name="id_product">
                    <input type="hidden" value="1" name="add">
                    <input type="hidden" value="" id="idCombination" name="id_product_attribute">
                    <div class="content_prices clearfix">
                        <!-- prices -->


                        <div class="price">
                            <p class="our_price_display">
                                <span id="our_price_display">$66.05</span>
                                <!---->
                            </p>

                        </div>
                        <p style="display:none;" id="reduction_percent"><span id="reduction_percent_display"></span></p>
                        <p style="display:none" id="reduction_amount">
                            <span id="reduction_amount_display">
                            </span>
                        </p>
                        <p class="hidden" id="old_price" style="display: none;">
                            <span id="old_price_display" style="display: none;">$66.05</span>
                            <!--  -->
                        </p>

                        <p class="buttons_bottom_block" id="add_to_cart">
                            <span></span>
                            <input type="submit" class="exclusive" value="Add to cart" name="Submit">
                        </p>

                        <div class="clear"></div>
                    </div>
                    <ul id="thumbs_list_frame">
                        <li id="thumbnail_23">
                            <a title="iPod shuffle" class="thickbox shown" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/3/23-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod shuffle" alt="iPod shuffle" src="http://localhost/prestashop/prestashop_156/img/p/2/3/23-medium_default.jpg" id="thumb_23">
                            </a>
                        </li>
                        <li id="thumbnail_24">
                            <a title="iPod shuffle" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/4/24-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod shuffle" alt="iPod shuffle" src="http://localhost/prestashop/prestashop_156/img/p/2/4/24-medium_default.jpg" id="thumb_24">
                            </a>
                        </li>
                        <li id="thumbnail_25">
                            <a title="iPod shuffle" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/5/25-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod shuffle" alt="iPod shuffle" src="http://localhost/prestashop/prestashop_156/img/p/2/5/25-medium_default.jpg" id="thumb_25">
                            </a>
                        </li>
                        <li id="thumbnail_26">
                            <a title="iPod shuffle" class="thickbox" rel="other-views" href="http://localhost/prestashop/prestashop_156/img/p/2/6/26-thickbox_default.jpg">
                                <img width="58" height="58" title="iPod shuffle" alt="iPod shuffle" src="http://localhost/prestashop/prestashop_156/img/p/2/6/26-medium_default.jpg" id="thumb_26">
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

$html = '';
$html = ob_get_contents();
ob_end_clean();
$datahtml = array(
    popin => $html
);
echo json_encode($datahtml);
?>