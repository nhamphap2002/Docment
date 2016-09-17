/*
 * 2007-2013 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author PrestaShop SA <contact@prestashop.com>
 *  @copyright  2007-2013 PrestaShop SA
 *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */


//global variables
var pcombinations = [];
var pselectedCombination = [];
var globalQuantity = 0;
var colors = [];


//add a combination of attributes in the global JS sytem
function paddCombination(idProduct, idCombination, arrayOfIdAttributes, quantity, price, ecotax, id_image, reference, unit_price, minimal_quantity, available_date, combination_specific_price) {
    //console.log('addCombination');
    globalQuantity += quantity;

    var combination = [];
    combination['idCombination'] = idCombination;
    combination['quantity'] = quantity;
    combination['idsAttributes'] = arrayOfIdAttributes;
    combination['price'] = price;
    combination['ecotax'] = ecotax;
    combination['image'] = id_image;
    combination['reference'] = reference;
    combination['unit_price'] = unit_price;
    combination['minimal_quantity'] = minimal_quantity;
    combination['available_date'] = [];
    combination['available_date'] = available_date;
    combination['specific_price'] = [];
    combination['specific_price'] = combination_specific_price;
    combination['idProduct'] = idProduct;
    return pcombinations.push(combination);
}

// search the pcombinations' case of attributes and update displaying of availability, prices, ecotax, and image
function pfindCombination(firstTime) {
    //console.log('pfindCombination');
    if ($(firstTime).is('.pcol'))
        var $form = firstTime;
    else if ($(firstTime).is('.attribute_radio'))
        var $form = $(firstTime).parent().parent().parent().parent().parent().parent().parent();
    else
        var $form = $(firstTime).parent().parent().parent().parent().parent();
    loadData($form);

    $form.find('#minimal_quantity_wanted_p').fadeOut();
    $form.find('#quantity_wanted').val(1);
    //create a temporary 'choice' array containing the choices of the customer
    var choice = [];
    $form.find('#pattributes select, #pattributes input[type=hidden], #pattributes input[type=radio]:checked').each(function() {
        choice.push($(this).val());
    });

    //testing every combination to find the conbination's attributes' case of the user
    for (var combination = 0; combination < pcombinations.length; ++combination)
    {
        //verify if this combinaison is the same that the user's choice
        if (pcombinations[combination]['idProduct'] == pid_product) {
            var combinationMatchForm = true;
            $.each(pcombinations[combination]['idsAttributes'], function(key, value) {
                //console.log(value, choice)
                if (!fgc_in_array(value, choice))
                    combinationMatchForm = false;
            });
        }
        //console.log('pcombinations[combination]', pcombinations[combination])
        //console.log('combination', combination)
        //console.log('pcombinations', pcombinations)
        //console.log(combinationMatchForm)
        if (combinationMatchForm) {
            if (pcombinations[combination]['minimal_quantity'] > 1) {
                $form.find('#minimal_quantity_label').html(pcombinations[combination]['minimal_quantity']);
                $form.find('#minimal_quantity_wanted_p').fadeIn();
                $form.find('#quantity_wanted').val(pcombinations[combination]['minimal_quantity']);
                $form.find('#quantity_wanted').bind('keyup', function() {
                    pcheckMinimalQuantity(pcombinations[combination]['minimal_quantity']);
                });
            }
            //combination of the user has been found in our specifications of pcombinations (created in back office)
            pselectedCombination['unavailable'] = false;
            pselectedCombination['reference'] = pcombinations[combination]['reference'];
            //Thuc hien gan gia tri cua idCombination
            $form.find('#idCombination').val(pcombinations[combination]['idCombination']);

            //get the data of product with these attributes
            pquantityAvailable = pcombinations[combination]['quantity'];
            pselectedCombination['price'] = pcombinations[combination]['price'];
            pselectedCombination['unit_price'] = pcombinations[combination]['unit_price'];
            pselectedCombination['specific_price'] = pcombinations[combination]['specific_price'];
            if (pcombinations[combination]['ecotax'])
                pselectedCombination['ecotax'] = pcombinations[combination]['ecotax'];
            else
                pselectedCombination['ecotax'] = pdefault_eco_tax;

            //show the large image in relation to the selected combination
            if (pcombinations[combination]['image'] && pcombinations[combination]['image'] != -1)
                pdisplayImage($form, $form.find('#thumb_' + pcombinations[combination]['image']).parent());

            //show discounts values according to the selected combination
            if (pcombinations[combination]['idCombination'] && pcombinations[combination]['idCombination'] > 0)
                pdisplayDiscounts(pcombinations[combination]['idCombination']);

            //get available_date for combination product
            pselectedCombination['available_date'] = pcombinations[combination]['available_date'];

            //update the display
            pupdateDisplay($form);

            //leave the function because combination has been found
            return;
        }
    }
    //this combination doesn't exist (not created in back office)
    pselectedCombination['unavailable'] = true;
    if (typeof (pselectedCombination['available_date']) != 'undefined')
        delete pselectedCombination['available_date'];
    pupdateDisplay($form);
}

//update display of the availability of the product AND the prices of the product
function pupdateDisplay(pform) {
    //console.log('pupdateDisplay');

    var productPriceDisplay = pproductPrice;
    var productPriceWithoutReductionDisplay = pproductPriceWithoutReduction;

    if (!pselectedCombination['unavailable'] && pquantityAvailable > 0 && pproductAvailableForOrder == 1)
    {
        //show the choice of quantities
        pform.find('#quantity_wanted_p:hidden').show('slow');

        //show the "add to cart" button ONLY if it was hidden
        pform.find('#padd_to_cart:hidden').fadeIn(600);

        //hide the hook out of stock
        pform.find('#oosHook').hide();

        pform.find('#availability_date').fadeOut();

        //availability value management
        if (pavailableNowValue != '')
        {
            //update the availability statut of the product
            pform.find('#availability_value').removeClass('warning_inline');
            pform.find('#availability_value').text(pavailableNowValue);
            if (pstock_management == 1)
                pform.find('#availability_statut:hidden').show();
        }
        else
            pform.find('#availability_statut:visible').hide();

        //'last quantities' message management
        if (!pallowBuyWhenOutOfStock)
        {
            if (pquantityAvailable <= pmaxQuantityToAllowDisplayOfLastQuantityMessage)
                pform.find('#last_quantities').show('slow');
            else
                pform.find('#last_quantities').hide('slow');
        }

        if (pquantitiesDisplayAllowed)
        {
            pform.find('#pQuantityAvailable:hidden').show('slow');
            pform.find('#quantityAvailable').text(pquantityAvailable);

            if (pquantityAvailable < 2) // we have 1 or less product in stock and need to show "item" instead of "items"
            {
                pform.find('#quantityAvailableTxt').show();
                pform.find('#quantityAvailableTxtMultiple').hide();
            }
            else
            {
                pform.find('#quantityAvailableTxt').hide();
                pform.find('#quantityAvailableTxtMultiple').show();
            }
        }
    } else {
        //show the hook out of stock
        if (pproductAvailableForOrder == 1)
        {
            //pform.find('#oosHook').show();
            //if (pform.find('#oosHook').length > 0 && function_exists('oosHookJsCode'))
            //oosHookJsCode();
        }

        //hide 'last quantities' message if it was previously visible
        pform.find('#last_quantities:visible').hide('slow');

        //hide the quantity of pieces if it was previously visible
        pform.find('#pQuantityAvailable:visible').hide('slow');

        //hide the choice of quantities
        if (!pallowBuyWhenOutOfStock)
            pform.find('#quantity_wanted_p:visible').hide('slow');

        //display that the product is unavailable with theses attributes
        if (!pselectedCombination['unavailable'])
            pform.find('#availability_value').text(doesntExistNoMore + (globalQuantity > 0 ? ' ' + doesntExistNoMoreBut : '')).addClass('warning_inline');
        else
        {
            pform.find('#availability_value').text(doesntExist).addClass('warning_inline');
            pform.find('#oosHook').hide();
        }
        if (pstock_management == 1 && !pallowBuyWhenOutOfStock)
            pform.find('#availability_statut:hidden').show();

        if (typeof (pselectedCombination['available_date']) != 'undefined' && pselectedCombination['available_date']['date'].length != 0)
        {
            var available_date = pselectedCombination['available_date']['date'];
            var tab_date = available_date.split('-');
            var time_available = new Date(tab_date[0], tab_date[1], tab_date[2]);
            time_available.setMonth(time_available.getMonth() - 1);
            var now = new Date();
            if (now.getTime() < time_available.getTime() && $('#availability_date_value').text() != pselectedCombination['available_date']['date_formatted'])
            {
                pform.find('#availability_date').fadeOut('normal', function() {
                    pform.find('#availability_date_value').text(pselectedCombination['available_date']['date_formatted']);
                    $(this).fadeIn();
                });
            }
            else if (now.getTime() < time_available.getTime())
                pform.find('#availability_date').fadeIn();
        }
        else
            pform.find('#availability_date').fadeOut();

        //show the 'add to cart' button ONLY IF it's possible to buy when out of stock AND if it was previously invisible
        if (pallowBuyWhenOutOfStock && !pselectedCombination['unavailable'] && pproductAvailableForOrder == 1)
        {
            pform.find('#padd_to_cart:hidden').fadeIn(600);

            if (pavailableLaterValue != '')
            {
                pform.find('#availability_value').text(pavailableLaterValue);
                if (pstock_management == 1)
                    pform.find('#availability_statut:hidden').show('slow');
            }
            else
                pform.find('#availability_statut:visible').hide('slow');
        }
        else
        {
            pform.find('#padd_to_cart:visible').fadeOut(600);
            if (pstock_management == 1)
                pform.find('#availability_statut:hidden').show('slow');
        }

        if (pproductAvailableForOrder == 0)
            pform.find('#availability_statut:visible').hide();
    }

    if (pselectedCombination['reference'] || pproductReference)
    {
        if (pselectedCombination['reference'])
            pform.find('#product_reference span').text(pselectedCombination['reference']);
        else if (pproductReference)
            pform.find('#product_reference span').text(pproductReference);
        pform.find('#product_reference:hidden').show('slow');
    }
    else
        pform.find('#product_reference:visible').hide('slow');

    //update display of the the prices in relation to tax, discount, ecotax, and currency criteria
    if (!pselectedCombination['unavailable'] && pproductShowPrice == 1)
    {
        var priceTaxExclWithoutGroupReduction = '';

        // retrieve price without group_reduction in order to compute the group reduction after
        // the specific price discount (done in the JS in order to keep backward compatibility)		
        priceTaxExclWithoutGroupReduction = ps_round(pproductPriceTaxExcluded, 6) * (1 / pgroup_reduction);

        var tax = (taxRate / 100) + 1;
        var taxExclPrice = priceTaxExclWithoutGroupReduction + (pselectedCombination['price'] * currencyRate);

        if (pselectedCombination.specific_price && pselectedCombination.specific_price['id_product_attribute'])
        {
            if (pselectedCombination.specific_price['price'] && pselectedCombination.specific_price['price'] >= 0)
                var taxExclPrice = (pspecific_currency ? pselectedCombination.specific_price['price'] : pselectedCombination.specific_price['price'] * currencyRate);
            else
                var taxExclPrice = pproductBasePriceTaxExcluded * currencyRate + (pselectedCombination['price'] * currencyRate);
        }
        else if (pproduct_specific_price.price && pproduct_specific_price.price >= 0)
            var taxExclPrice = (pspecific_currency ? pproduct_specific_price.price : pproduct_specific_price.price * currencyRate) + (pselectedCombination['price'] * currencyRate);

        if (!pdisplayPrice && !pnoTaxForThisProduct)
            productPriceDisplay = ps_round(taxExclPrice * tax, 2); // Need to be global => no var
        else
            productPriceDisplay = ps_round(taxExclPrice, 2); // Need to be global => no var

        productPriceWithoutReductionDisplay = productPriceDisplay * pgroup_reduction;
        var reduction = 0;
        if (pselectedCombination['specific_price'].reduction_price || pselectedCombination['specific_price'].reduction_percent)
        {
            preduction_price = (pspecific_currency ? pselectedCombination['specific_price'].reduction_price : pselectedCombination['specific_price'].reduction_price * currencyRate);
            reduction = productPriceDisplay * (parseFloat(pselectedCombination['specific_price'].reduction_percent) / 100) + preduction_price;
            if (preduction_price && (pdisplayPrice || pnoTaxForThisProduct))
                reduction = ps_round(reduction / tax, 6);

        }
        else if (pproduct_specific_price && pproduct_specific_price.reduction && !pselectedCombination.specific_price)
        {
            if (pproduct_specific_price.reduction_type == 'amount')
                preduction_price = (pspecific_currency ? pproduct_specific_price.reduction : pproduct_specific_price.reduction * currencyRate);
            else
                preduction_price = 0;

            if (pproduct_specific_price.reduction_type == 'percentage')
                preduction_percent = productPriceDisplay * parseFloat(pproduct_specific_price.reduction);

            reduction = preduction_price + preduction_percent;
            if (preduction_price && (pdisplayPrice || pnoTaxForThisProduct))
                reduction = ps_round(reduction / tax, 6);
        }

        if (pselectedCombination.specific_price)
        {
            if (pselectedCombination['specific_price'] && pselectedCombination['specific_price'].reduction_type == 'percentage')
            {
                pform.find('#reduction_amount').hide();
                pform.find('#reduction_percent_display').html('-' + parseFloat(pselectedCombination['specific_price'].reduction_percent) + '%');
                pform.find('#reduction_percent').show();
            } else if (pselectedCombination['specific_price'].reduction_type == 'amount' && pselectedCombination['specific_price'].reduction_price != 0) {
                pform.find('#reduction_amount_display').html('-' + formatCurrency(preduction_price, currencyFormat, currencySign, currencyBlank));
                pform.find('#reduction_percent').hide();
                pform.find('#reduction_amount').show();
            } else {
                pform.find('#reduction_percent').hide();
                pform.find('#reduction_amount').hide();
            }
        }

        if (pproduct_specific_price['reduction_type'] != '' || pselectedCombination['specific_price'].reduction_type != '')
            pform.find('#discount_reduced_price,#old_price').show();
        else
            pform.find('#discount_reduced_price,#old_price').hide();
        if ((pproduct_specific_price['reduction_type'] == 'percentage' && pselectedCombination['specific_price'].reduction_type == 'percentage') || pselectedCombination['specific_price'].reduction_type == 'percentage')
            pform.find('#reduction_percent').show();
        else
            pform.find('#reduction_percent').hide();
        if (pproduct_specific_price['price'] || (pselectedCombination.specific_price && pselectedCombination.specific_price['price']))
            pform.find('#not_impacted_by_discount').show();
        else
            pform.find('#not_impacted_by_discount').hide();

        productPriceDisplay -= reduction;
        productPriceDisplay = ps_round(productPriceDisplay * pgroup_reduction, 2);

        var ecotaxAmount = !pdisplayPrice ? ps_round(pselectedCombination['ecotax'] * (1 + pecotaxTax_rate / 100), 2) : pselectedCombination['ecotax'];

        if (ecotaxAmount != pdefault_eco_tax)
            productPriceDisplay += ecotaxAmount - pdefault_eco_tax;
        else
            productPriceDisplay += ecotaxAmount;

        if (ecotaxAmount != pdefault_eco_tax)
            productPriceWithoutReductionDisplay += ecotaxAmount - pdefault_eco_tax;
        else
            productPriceWithoutReductionDisplay += ecotaxAmount;

        //formatCurrency(price, currencyFormat, currencySign, currencyBlank)
        var our_price = '';
        if (productPriceDisplay > 0) {
            our_price = formatCurrency(productPriceDisplay, currencyFormat, currencySign, currencyBlank);
        } else {
            our_price = formatCurrency(0, currencyFormat, currencySign, currencyBlank);
        }

        pform.find('#our_price_display').text(our_price);
        pform.find('#old_price_display').text(formatCurrency(productPriceWithoutReductionDisplay, currencyFormat, currencySign, currencyBlank));

        if (productPriceWithoutReductionDisplay > productPriceDisplay)
            pform.find('#old_price,#old_price_display,#old_price_display_taxes').show();
        else
            pform.find('#old_price,#old_price_display,#old_price_display_taxes').hide();
        // Special feature: "Display product price tax excluded on product page"
        var productPricePretaxed = '';
        if (!pnoTaxForThisProduct)
            productPricePretaxed = productPriceDisplay / tax;
        else
            productPricePretaxed = productPriceDisplay;
        pform.find('#pretaxe_price_display').text(formatCurrency(productPricePretaxed, currencyFormat, currencySign, currencyBlank));
        // Unit price 
        pproductUnitPriceRatio = parseFloat(pproductUnitPriceRatio);
        if (pproductUnitPriceRatio > 0)
        {
            newUnitPrice = (productPriceDisplay / parseFloat(pproductUnitPriceRatio)) + pselectedCombination['unit_price'];
            pform.find('#unit_price_display').text(formatCurrency(newUnitPrice, currencyFormat, currencySign, currencyBlank));
        }

        // Ecotax
        ecotaxAmount = !pdisplayPrice ? ps_round(pselectedCombination['ecotax'] * (1 + pecotaxTax_rate / 100), 2) : pselectedCombination['ecotax'];
        pform.find('#ecotax_price_display').text(formatCurrency(ecotaxAmount, currencyFormat, currencySign, currencyBlank));
    }
}

//update display of the large image
function pdisplayImage($form, domAAroundImgThumb, no_animation) {
    //console.log('displayImage');
    if (typeof (no_animation) == 'undefined')
        no_animation = false;
    if (domAAroundImgThumb.prop('href'))
    {
        var new_src = domAAroundImgThumb.prop('href').replace('thickbox', 'large');
        var new_title = domAAroundImgThumb.prop('title');
        var new_href = domAAroundImgThumb.prop('href');
        if ($form.find('#pbigpic').prop('src') != new_src)
        {
            $form.find('#pbigpic').prop({
                'src': new_src,
                'alt': new_title,
                'title': new_title
            }).load(function() {

            });
        }
        $form.find(domAAroundImgThumb).addClass('shown');
    }
}

//update display of the discounts table
function pdisplayDiscounts(combination) {
    //console.log('displayDiscounts');

    $('#quantityDiscount tbody tr').each(function() {
        if (($(this).attr('id') != 'quantityDiscount_0') &&
                ($(this).attr('id') != 'quantityDiscount_' + combination) &&
                ($(this).attr('id') != 'noQuantityDiscount'))
            $(this).fadeOut('slow');
    });

    if ($('#quantityDiscount_' + combination + ',.quantityDiscount_' + combination).length != 0)
    {
        $('#quantityDiscount_' + combination + ',.quantityDiscount_' + combination).show();
        $('#noQuantityDiscount').hide();
    }
    else
        $('#noQuantityDiscount').show();
}

//To do after loading HTML
$(document).ready(function() {

    //init the price in relation of the selected attributes
    if (typeof pproductHasAttributes != 'undefined' && pproductHasAttributes) {
        $('.modal-crossselling').find(".pcol").each(function(i) {
            if ($(this).find('.attribute_fieldset').html() != null) {
                pfindCombination($(this));
                pgetProductAttribute();
            }
        })
    }
    $('.modal-crossselling').find(".pcol").each(function(i) {
        if ($(this).find('.attribute_fieldset').html() != null) {
            pfindCombination($(this));
            pgetProductAttribute();
        }
    })

    $('.ppopup_close, #pcontinueshop, .main-poup .close').live('click', function(e) {
        e.preventDefault()
        $('.modal-crossselling').hide();
        $('body').removeClass('js-no-scroll');
    });

});


function pcheckMinimalQuantity(minimal_quantity) {
    //console.log('checkMinimalQuantity');
    if ($('#quantity_wanted').val() < minimal_quantity)
    {
        $('#quantity_wanted').css('border', '1px solid red');
        $('#minimal_quantity_wanted_p').css('color', 'red');
    }
    else
    {
        $('#quantity_wanted').css('border', '1px solid #BDC2C9');
        $('#minimal_quantity_wanted_p').css('color', '#374853');
    }
}

function pcolorPickerClick(elt) {
    //console.log('colorPickerClick');
    pid_attribute = $(elt).attr('id').replace('color_', '');
    $(elt).parent().parent().children().removeClass('selected');
    $(elt).fadeTo('fast', 1, function() {
        $(this).fadeTo('fast', 0, function() {
            $(this).fadeTo('fast', 1, function() {
                $(this).parent().addClass('selected');
            });
        });
    });
    var $form = $(elt).parent().parent().parent().parent().parent().parent().parent().parent();
    $form.find('.color_pick_hidden,#color_pick_hidden').val(pid_attribute);
    pfindCombination($form);
}


function pgetProductAttribute() {
    //console.log('pgetProductAttribute');

}

//verify if value is in the array
function fgc_in_array(value, array)
{
    for (var i in array)
        if (array[i] === value)
            return true;
    return false;
}

function  loadData(pform) {

    pid_product = pform.find('input[name=id_product]').val();

    pproductHasAttributes = arrproductHasAttributes['p_' + pid_product];

    pquantitiesDisplayAllowed = arrquantitiesDisplayAllowed['p_' + pid_product];

    pquantityAvailable = parseInt(arrquantityAvailable['p_' + pid_product]);

    pallowBuyWhenOutOfStock = arrallowBuyWhenOutOfStock['p_' + pid_product];

    pavailableNowValue = arravailableNowValue['p_' + pid_product];

    pavailableLaterValue = arravailableLaterValue['p_' + pid_product];

    pproductPriceTaxExcluded = parseFloat(arrproductPriceTaxExcluded['p_' + pid_product]);

    pproductBasePriceTaxExcluded = parseFloat(arrproductBasePriceTaxExcluded['p_' + pid_product]);

    preduction_percent = parseInt(arrreduction_percent['p_' + pid_product]);

    preduction_price = parseInt(arrreduction_price['p_' + pid_product]);

    pspecific_price = parseFloat(arrspecific_price['p_' + pid_product]);

    pproduct_specific_price['id_specific_price'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_specific_price']);

    pproduct_specific_price['id_specific_price_rule'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_specific_price_rule']);

    pproduct_specific_price['id_cart'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_cart']);

    pproduct_specific_price['id_product'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_product']);

    pproduct_specific_price['id_shop'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_shop']);

    pproduct_specific_price['id_shop_group'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_shop_group']);

    pproduct_specific_price['id_currency'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_currency']);

    pproduct_specific_price['id_country'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_country']);

    pproduct_specific_price['id_group'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_group']);

    pproduct_specific_price['id_customer'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_customer']);

    pproduct_specific_price['id_product_attribute'] = parseInt(arrproduct_specific_price['p_' + pid_product]['id_product_attribute']);

    pproduct_specific_price['price'] = parseFloat(arrproduct_specific_price['p_' + pid_product]['price']);

    pproduct_specific_price['from_quantity'] = parseInt(arrproduct_specific_price['p_' + pid_product]['from_quantity']);

    pproduct_specific_price['reduction'] = parseFloat(arrproduct_specific_price['p_' + pid_product]['reduction']);

    pproduct_specific_price['reduction_type'] = arrproduct_specific_price['p_' + pid_product]['reduction_type'];

    pproduct_specific_price['from'] = arrproduct_specific_price['p_' + pid_product]['from'];

    pproduct_specific_price['to'] = arrproduct_specific_price['p_' + pid_product]['to'];

    pproduct_specific_price['score'] = parseInt(arrproduct_specific_price['p_' + pid_product]['score']);

    pspecific_currency = arrspecific_currency['p_' + pid_product];

    pgroup_reduction = parseInt(arrgroup_reduction['p_' + pid_product]);

    pdefault_eco_tax = parseFloat(arrdefault_eco_tax['p_' + pid_product]);

    pecotaxTax_rate = parseInt(arrecotaxTax_rate['p_' + pid_product]);

    pcurrentDate = arrcurrentDate['p_' + pid_product];

    pmaxQuantityToAllowDisplayOfLastQuantityMessage = parseInt(arrmaxQuantityToAllowDisplayOfLastQuantityMessage['p_' + pid_product]);

    pnoTaxForThisProduct = arrnoTaxForThisProduct['p_' + pid_product];

    pdisplayPrice = parseInt(arrdisplayPrice['p_' + pid_product]);

    pproductReference = arrproductReference['p_' + pid_product];

    pproductAvailableForOrder = parseInt(arrproductAvailableForOrder['p_' + pid_product]);

    pproductShowPrice = parseInt(arrproductShowPrice['p_' + pid_product]);

    pproductUnitPriceRatio = parseFloat(arrproductUnitPriceRatio['p_' + pid_product]);

    pidDefaultImage = parseInt(arridDefaultImage['p_' + pid_product]);

    pstock_management = parseInt(arrstock_management['p_' + pid_product]);

    pproductPriceWithoutReduction = parseFloat(arrproductPriceWithoutReduction['p_' + pid_product]);

    pproductPrice = parseFloat(arrproductPrice['p_' + pid_product]);
}