<script type="text/javascript">
    var id_product = '{$accessory.product->id|intval}';
    arrproductHasAttributes['p_{$accessory.product->id|intval}'] = {if isset($accessory.groups)}true{else}false{/if};

        arrquantitiesDisplayAllowed['p_{$accessory.product->id|intval}'] = {if $accessory.display_qties == 1}true{else}false{/if};

            arrquantityAvailable['p_{$accessory.product->id|intval}'] = {if $accessory.display_qties == 1 && $accessory.product->quantity}{$accessory.product->quantity}{else}0{/if};

                arrallowBuyWhenOutOfStock['p_{$accessory.product->id|intval}'] = {if $accessory.allow_oosp == 1}true{else}false{/if};

                    arravailableNowValue['p_{$accessory.product->id|intval}'] = '{$accessory.product->available_now|escape:'quotes':'UTF-8'}';

                    arravailableLaterValue['p_{$accessory.product->id|intval}'] = '{$accessory.product->available_later|escape:'quotes':'UTF-8'}';

                    arrproductPriceTaxExcluded['p_{$accessory.product->id|intval}'] = {$accessory.product->getPriceWithoutReduct(true)|default:'null'} - {$accessory.product->ecotax};

                    arrproductBasePriceTaxExcluded['p_{$accessory.product->id|intval}'] = {$accessory.product->base_price} - {$accessory.product->ecotax};

                    arrreduction_percent['p_{$accessory.product->id|intval}'] = {if $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction AND $accessory.product->specificPrice.reduction_type == 'percentage'}{$accessory.product->specificPrice.reduction*100}{else}0{/if};

                        arrreduction_price['p_{$accessory.product->id|intval}'] = {if $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction AND $accessory.product->specificPrice.reduction_type == 'amount'}{$accessory.product->specificPrice.reduction|floatval}{else}0{/if};

                            arrspecific_price['p_{$accessory.product->id|intval}'] = {if $accessory.product->specificPrice AND $accessory.product->specificPrice.price}{$accessory.product->specificPrice.price}{else}0{/if};

                                arrproduct_specific_price['p_{$accessory.product->id|intval}'] = new Array();
    {foreach from=$accessory.product->specificPrice key='key_specific_price' item='specific_price_value'}
                                arrproduct_specific_price['p_{$accessory.product->id|intval}']['{$key_specific_price}'] = '{$specific_price_value}';
    {/foreach}

                                arrspecific_currency['p_{$accessory.product->id|intval}'] = {if $accessory.product->specificPrice AND $accessory.product->specificPrice.id_currency}true{else}false{/if};

                                    arrgroup_reduction['p_{$accessory.product->id|intval}'] = '{$accessory.group_reduction}';

                                    arrdefault_eco_tax['p_{$accessory.product->id|intval}'] = {$accessory.product->ecotax};

                                    arrecotaxTax_rate['p_{$accessory.product->id|intval}'] = {$accessory.ecotaxTax_rate};

                                    arrcurrentDate['p_{$accessory.product->id|intval}'] = '{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}';

                                    arrmaxQuantityToAllowDisplayOfLastQuantityMessage['p_{$accessory.product->id|intval}'] = {$accessory.last_qties};

                                    arrnoTaxForThisProduct['p_{$accessory.product->id|intval}'] = {if $accessory.no_tax == 1}true{else}false{/if};

                                        arrdisplayPrice['p_{$accessory.product->id|intval}'] ={$priceDisplay};

                                        arrproductReference['p_{$accessory.product->id|intval}'] = '{$accessory.product->reference|escape:'htmlall':'UTF-8'}';

                                        arrproductAvailableForOrder['p_{$accessory.product->id|intval}'] = {if (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE}
                                        '0'{else}'{$accessory.product->available_for_order}'{/if};
                                                arrproductShowPrice['p_{$accessory.product->id|intval}'] = '{if !$PS_CATALOG_MODE}{$accessory.product->show_price}{else}0{/if}';

                                                    arrproductUnitPriceRatio['p_{$accessory.product->id|intval}'] = '{$accessory.product->unit_price_ratio}';

                                                    arridDefaultImage['p_{$accessory.product->id|intval}'] = {if isset($accessory.images.cover.id_image_only)}{$accessory.images.cover.id_image_only}{else}0{/if};

                                                        arrstock_management['p_{$accessory.product->id|intval}'] ={$stock_management|intval};
    {if !isset($priceDisplayPrecision)}
        {assign var='priceDisplayPrecision' value=2}
    {/if}
    {if !$priceDisplay || $priceDisplay == 2}
        {assign var='productPrice' value=$accessory.product->getPrice(true, $smarty.const.NULL, $priceDisplayPrecision)}
        {assign var='productPriceWithoutReduction' value=$accessory.product->getPriceWithoutReduct(false, $smarty.const.NULL)}
    {elseif $priceDisplay == 1}
        {assign var='productPrice' value=$accessory.product->getPrice(false, $smarty.const.NULL, $priceDisplayPrecision)}
        {assign var='productPriceWithoutReduction' value=$accessory.product->getPriceWithoutReduct(true, $smarty.const.NULL)}
    {/if}
                                                        arrproductPriceWithoutReduction['p_{$accessory.product->id|intval}'] = '{$productPriceWithoutReduction}';

                                                        arrproductPrice['p_{$accessory.product->id|intval}'] = '{$productPrice}';


// Translations
                                                        var doesntExist = '{l s='This combination does not exist for this product. Please choose another.' js=1}';
                                                        var doesntExistNoMore = '{l s='This product is no longer in stock' js=1}';
                                                        var doesntExistNoMoreBut = '{l s='try a different color or size' js=1}';
                                                        var uploading_in_progress = '{l s='Uploading in progress, please wait...' js=1}';
                                                        var fieldRequired = '{l s='Please fill in all required fields, then save the customization.' js=1}';


                                                        // Combinations
    {if isset($accessory.groups)}
                                                        // Combinations
        {foreach from=$accessory.combinations key=idCombination item=combination}
                                                        var specific_price_combination = new Array();
                                                        var available_date = new Array();
                                                        specific_price_combination['reduction_percent'] = {if $combination.specific_price AND $combination.specific_price.reduction AND $combination.specific_price.reduction_type == 'percentage'}{$combination.specific_price.reduction*100}{else}0{/if};
                                                            specific_price_combination['reduction_price'] = {if $combination.specific_price AND $combination.specific_price.reduction AND $combination.specific_price.reduction_type == 'amount'}{$combination.specific_price.reduction}{else}0{/if};
                                                                specific_price_combination['price'] = {if $combination.specific_price AND $combination.specific_price.price}{$combination.specific_price.price}{else}0{/if};
                                                                    specific_price_combination['reduction_type'] = '{if $combination.specific_price}{$combination.specific_price.reduction_type}{/if}';
                                                                    specific_price_combination['id_product_attribute'] = {if $combination.specific_price}{$combination.specific_price.id_product_attribute|intval}{else}0{/if};
                                                                        available_date['date'] = '{$combination.available_date}';
                                                                        available_date['date_formatted'] = '{dateFormat date=$combination.available_date full=false}';
                                                                        paddCombination({$accessory.product->id|intval},{$idCombination|intval}, new Array({$combination.list}), {$combination.quantity}, {$combination.price}, {$combination.ecotax}, {$combination.id_image}, '{$combination.reference|addslashes}', {$combination.unit_impact}, {$combination.minimal_quantity}, available_date, specific_price_combination);
                                                                        //console.log('id_product',{$accessory.product->id|intval}, ":",{$combination.list})
        {/foreach}
    {/if}
</script>