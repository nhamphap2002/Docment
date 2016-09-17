<script type="text/javascript">
    MC_AJAX_CALL = "{$url_base}modules/belvg_popupcart/popupaddtocart_ajax.php?ajax=1";
    ID_LANG = {$id_lang};
    MC_DISPLAY_WHEN_PRODUCTS_EXISTS = {$accessories|count};
    // PrestaShop internal settings
    var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
    var currencyRate = '{$currencyRate|floatval}';
    var currencyFormat = '{$currencyFormat|intval}';
    var currencyBlank = '{$currencyBlank|intval}';
    var taxRate = {$tax_rate|floatval};
    var jqZoomEnabled = {if $jqZoomEnabled}true{else}false{/if};
        // Parameters
        var pproduct_specific_price = new Array();
        var arrproductHasAttributes = new Array();
        var arrquantitiesDisplayAllowed = new Array();
        var arrquantityAvailable = new Array();
        var arrallowBuyWhenOutOfStock = new Array();
        var arravailableNowValue = new Array();
        var arravailableLaterValue = new Array();
        var arrproductPriceTaxExcluded = new Array();
        var arrproductBasePriceTaxExcluded = new Array();
        var arrreduction_percent = new Array();
        var arrreduction_price = new Array();
        var arrspecific_price = new Array();
        var arrproduct_specific_price = new Array();
        var arrspecific_currency = new Array();
        var arrgroup_reduction = new Array();
        var arrdefault_eco_tax = new Array();
        var arrecotaxTax_rate = new Array();
        var arrcurrentDate = new Array();
        var arrmaxQuantityToAllowDisplayOfLastQuantityMessage = new Array();
        var arrnoTaxForThisProduct = new Array();
        var arrdisplayPrice = new Array();
        var arrproductReference = new Array();
        var arrproductAvailableForOrder = new Array();
        var arrproductShowPrice = new Array();
        var arrproductUnitPriceRatio = new Array();
        var arridDefaultImage = new Array();
        var arrstock_management = new Array();
        var arrproductPriceWithoutReduction = new Array();
        var arrproductPrice = new Array();
</script>

<!-- Block popupaddtocart -->
{if isset($accessories) AND $accessories}
    <!-- accessories -->
    <div class="popup-addcart">
        <div class="modal-crossselling">
            <input type="hidden" id="current_product_name" value="{$current_product_name}"/>
            <div  class="p_popin">
                <div class="inner-popup">
                    <div class="inner-popup1">
                        <div class=product-title-main-poup>
                            <h3 class="title">
                                {l s='Product was successfully added to your shopping cart.' mod='belvg_popupcart'}
                            </h3>
                        </div>
                        <div class="main-poup" >

                            <img class="pimgproduct" src="" alt="image product">
                            <p class="des-main-poup">
                                1x iPod shuffle vert a été ajouté à votre panier 
                            </p>

                        </div>
                        <div class="pfooter">
                            <a id="pcontinueshop" href="{$link->getPageLink('index', true)|escape:'html'}" class="exclusive">
                                {l s='Shopping' mod='belvg_popupcart'}
                            </a>

                            <a href="{$link->getPageLink("order-opc", true)|escape:'html'}" id="button_order_cart" class="exclusive_large" title="{l s='Checkout' mod='blockcart'}" rel="nofollow"><span></span>{l s='Checkout' mod='blockcart'}</a>

                        </div>
                        <div class=product-title-main-poup>
                            <h3>{l s='You may also like' mod='belvg_popupcart'}:</h3>
                        </div>
                        <div class="pinner">

                            {foreach from=$accessories item=accessory name=accessories_list}
                                {assign var='accessoryLink' value=$link->getProductLink($accessory.id_product, $accessory.link_rewrite, $accessory.category)}
                                <div class="pcol index_{($smarty.foreach.accessories_list.index + 1)}">
                                    <form action="{$url_base}index.php?controller=cart" method="post">

                                        <div class="product_desc">
                                            <a href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{$accessory.name|escape:'htmlall':'UTF-8'}" class="product_image">
                                                <img id="pbigpic" src="{$link->getImageLink($accessory.link_rewrite, $accessory.id_image, 'home_default')|escape:'html'}" alt="{$accessory.name|escape:'htmlall':'UTF-8'}" width="{$mediumSize.width}" height="{$mediumSize.height}" />
                                            </a>
                                            <div class="block_description">
                                                <a href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{l s='More' mod='belvg_popupcart'}" class="product_description">{$accessory.description_short|strip_tags|truncate:400:'...'}</a>
                                            </div>
                                            <div class="clear_product_desc">&nbsp;</div>
                                        </div>
                                        <div class="ajax_block_product{if $smarty.foreach.accessories_list.first} first_item{elseif $smarty.foreach.accessories_list.last} last_item{else} item{/if} product_accessories_description">
                                            {include file="$tpl_dir/../../modules/belvg_popupcart/createdjs.tpl"}
                                            <p class="s_title_block">
                                                <a href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{$accessory.name|escape:'htmlall':'UTF-8'}">
                                                    {$accessory.name|escape:'htmlall':'UTF-8'}
                                                </a>
                                                {if $accessory.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
                                                    <span class="price"> - {if $priceDisplay != 1}{displayWtPrice p=$accessory.price}{else}{displayWtPrice p=$accessory.price_tax_exc}{/if}</span>
                                                {/if}
                                            </p>
                                        </div>
                                        <p id="pbuttoncart" class="clearfix" style="margin-top:5px">
                                            <a class="button" href="{$accessoryLink|escape:'htmlall':'UTF-8'}" title="{l s='View' mod='belvg_popupcart'}">{l s='View' mod='belvg_popupcart'}</a>
                                            {if !$PS_CATALOG_MODE && ($accessory.allow_oosp || $accessory.quantity > 0)}
                                                <a class="exclusive button ajax_add_to_cart_button" href="{$link->getPageLink('cart', true, NULL, "qty=1&amp;id_product={$accessory.id_product|intval}&amp;token={$static_token}&amp;add")|escape:'html'}" rel="ajax_id_product_{$accessory.id_product|intval}" title="{l s='Add to cart' mod='belvg_popupcart'}">{l s='Add to cart' mod='belvg_popupcart'}</a>
                                            {/if}
                                        </p>

                                        <!-- attributes -->
                                        <div class="product_attributes {if $accessory.groups|count<=0} disnone{/if}">
                                            <div id="pattributes">
                                                <div class="clear"></div>
                                                {foreach from=$accessory.groups key=id_attribute_group item=group}
                                                    {if $group.attributes|@count}
                                                        <fieldset class="attribute_fieldset">
                                                            <label class="attribute_label" for="group_{$id_attribute_group|intval}">{$group.name|escape:'htmlall':'UTF-8'} :&nbsp;</label>
                                                            {assign var="groupName" value="group_$id_attribute_group"}
                                                            <div class="attribute_list">
                                                                {if ($group.group_type == 'select')}
                                                                    <select name="{$groupName}" id="group_{$id_attribute_group|intval}" class="attribute_select" onchange="pfindCombination(this);
                                                                            pgetProductAttribute(this);">
                                                                        {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                                            <option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'htmlall':'UTF-8'}">{$group_attribute|escape:'htmlall':'UTF-8'}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                {elseif ($group.group_type == 'color')}
                                                                    <ul id="color_to_pick_list" class="clearfix">
                                                                        {assign var="default_colorpicker" value=""}
                                                                        {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                                            <li{if $group.default == $id_attribute} class="selected"{/if}>
                                                                                <a id="color_{$id_attribute|intval}" class="color_pick{if ($group.default == $id_attribute)} selected{/if}" style="background: {$accessory.colors.$id_attribute.value};" title="{$accessory.colors.$id_attribute.name}" onclick="pcolorPickerClick(this);
                                                                                        pgetProductAttribute(this);">
                                                                                    {if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
                                                                                        <img src="{$img_col_dir}{$id_attribute}.jpg" alt="{$accessory.colors.$id_attribute.name}" width="20" height="20" /><br />
                                                                                    {/if}
                                                                                </a>
                                                                            </li>
                                                                            {if ($group.default == $id_attribute)}
                                                                                {$default_colorpicker = $id_attribute}
                                                                            {/if}
                                                                        {/foreach}
                                                                    </ul>
                                                                    <input type="hidden" class="color_pick_hidden" name="{$groupName}" value="{$default_colorpicker}" />
                                                                {elseif ($group.group_type == 'radio')}
                                                                    <ul>
                                                                        {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                                            <li>
                                                                                <input type="radio" class="attribute_radio" name="{$groupName}" value="{$id_attribute}" {if ($group.default == $id_attribute)} checked="checked"{/if} onclick="pfindCombination(this);
                                                                                        pgetProductAttribute(this);" />
                                                                                <span>{$group_attribute|escape:'htmlall':'UTF-8'}</span>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                {/if}
                                                            </div>
                                                        </fieldset>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        </div>
                                        <p id="product_reference" {if isset($accessory.groups) OR !$accessory.product->reference}style="display: none;"{/if}>
                                            <label>{l s='Reference:' mod='belvg_popupcart'} </label>
                                            <span class="editable">{$accessory.product->reference|escape:'htmlall':'UTF-8'}</span>
                                        </p>
                                        <!-- quantity wanted -->
                                        <p id="quantity_wanted_p"{if (!$accessory.allow_oosp && $accessory.product->quantity <= 0) OR $virtual OR !$accessory.product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
                                            <label>{l s='Quantity:' mod='belvg_popupcart'}</label>
                                            <input type="text" name="qty" id="quantity_wanted" class="text" value="{if isset($accessory.product->quantityBackup)}{$accessory.product->quantityBackup|intval}{else}{if $accessory.product->minimal_quantity > 1}{$accessory.product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $accessory.product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$accessory.product->minimal_quantity});"{/if} />
                                        </p>
                                        <!-- minimal quantity wanted -->
                                        <p id="minimal_quantity_wanted_p"{if $accessory.product->minimal_quantity <= 1 OR !$accessory.product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
                                            {l s='This product is not sold individually. You must select at least' mod='belvg_popupcart'} <b id="minimal_quantity_label">{$accessory.product->minimal_quantity}</b> {l s='quantity for this product.' mod='belvg_popupcart'}
                                        </p>
                                        {if $accessory.product->minimal_quantity > 1}
                                            <script type="text/javascript">
                                                checkMinimalQuantity();
                                            </script>
                                        {/if}
                                        <!-- availability -->
                                        <p id="availability_statut"{if ($accessory.product->quantity <= 0 && !$accessory.product->available_later && $accessory.allow_oosp) OR ($accessory.product->quantity > 0 && !$accessory.product->available_now) OR !$accessory.product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
                                            {if $accessory.product->quantity > 0}<span id="availability_label">{l s='Availability:' mod='belvg_popupcart'}</span>{/if}
                                            <span id="availability_value"
                                    {if $accessory.product->quantity <= 0} class="warning_inline"{/if}>{if $accessory.product->quantity <= 0}{if $accessory.allow_oosp}{$accessory.product->available_later}{else}{l s='This product is no longer in stock' mod='belvg_popupcart'}{/if}{else}{$accessory.product->available_now}{/if}</span>				
                            </p>
                            <p id="availability_date"{if ($accessory.product->quantity > 0) OR !$accessory.product->available_for_order OR $PS_CATALOG_MODE OR !isset($accessory.product->available_date) OR $accessory.product->available_date < $smarty.now|date_format:'%Y-%m-%d'} style="display: none;"{/if}>
                                <span id="availability_date_label">{l s='Availability date:' mod='belvg_popupcart'}</span>
                                <span id="availability_date_value">{dateFormat date=$accessory.product->available_date full=false}</span>
                            </p>
                            <!-- number of item in stock -->
                            {if ($accessory.display_qties == 1 && !$PS_CATALOG_MODE && $accessory.product->available_for_order)}
                                <p id="pQuantityAvailable"{if $accessory.product->quantity <= 0} style="display: none;"{/if}>
                                    <span id="quantityAvailable">{$accessory.product->quantity|intval}</span>
                                    <span {if $accessory.product->quantity > 1} style="display: none;"{/if} id="quantityAvailableTxt">{l s='Item in stock'}</span>
                                    <span {if $accessory.product->quantity == 1} style="display: none;"{/if} id="quantityAvailableTxtMultiple">{l s='Items in stock' mod='belvg_popupcart'}</span>
                                </p>
                            {/if}
                            <!-- Out of stock hook -->
                            <div id="oosHook"{if $accessory.product->quantity > 0} style="display: none;"{/if}>
                                {$HOOK_PRODUCT_OOS}
                            </div>

                            <p class="warning_inline" id="last_quantities"{if ($accessory.product->quantity > $accessory.last_qties OR $accessory.product->quantity <= 0) OR $accessory.allow_oosp OR !$accessory.product->available_for_order OR $PS_CATALOG_MODE} style="display: none"{/if} >{l s='Warning: Last items in stock!' mod='belvg_popupcart'}</p>

                            <div class="content_prices clearfix {if $accessory.groups|count<=0} nomar{/if}">
                                <!-- prices -->
                                {if $accessory.product->show_price}
                                    <div class="price">
                                        <p class="our_price_display">
                                            {if $priceDisplay >= 0 && $priceDisplay <= 2}
                                                <span id="our_price_display">{convertPrice price=$accessory.product->getPrice(false, $smarty.const.NULL, $priceDisplayPrecision)}</span>
                                                <!--{if $tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) OR !isset($display_tax_label))}
                                        {if $priceDisplay == 1}{l s='tax excl.' mod='belvg_popupcart'}{else}{l s='tax incl.' mod='belvg_popupcart'}{/if}
                                    {/if}-->
                                {/if}
                            </p>

                            {if $accessory.product->on_sale}
                                <img src="{$img_dir}onsale_{$lang_iso}.gif" alt="{l s='On sale' mod='belvg_popupcart'}" class="on_sale_img"/>
                                <span class="on_sale">{l s='On sale!' mod='belvg_popupcart'}</span>
                            {elseif $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction AND $productPriceWithoutReduction > $productPrice}
                                <span class="discount">{l s='Reduced price!' mod='belvg_popupcart'}</span>
                            {/if}
                            {if $priceDisplay == 2}
                                <br />
                                <span id="pretaxe_price"><span id="pretaxe_price_display">{convertPrice price=$accessory.product->getPrice(false, $smarty.const.NULL)}</span>&nbsp;{l s='tax excl.' mod='belvg_popupcart'}</span>
                            {/if}
                        </div>
                        <p id="reduction_percent" {if !$accessory.product->specificPrice OR $accessory.product->specificPrice.reduction_type != 'percentage'} style="display:none;"{/if}><span id="reduction_percent_display">{if $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction_type == 'percentage'}-{$accessory.product->specificPrice.reduction*100}%{/if}</span></p>
                        <p id="reduction_amount" {if !$accessory.product->specificPrice OR $accessory.product->specificPrice.reduction_type != 'amount' || $accessory.product->specificPrice.reduction|intval ==0} style="display:none"{/if}>
                            <span id="reduction_amount_display">
                                {if $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction_type == 'amount' AND $accessory.product->specificPrice.reduction|intval !=0}
                                    -{convertPrice price=$productPriceWithoutReduction-$productPrice|floatval}
                                {/if}
                            </span>
                        </p>
                        <p id="old_price"{if !$accessory.product->specificPrice || !$accessory.product->specificPrice.reduction} class="hidden"{/if}>
                            {if $priceDisplay >= 0 && $priceDisplay <= 2}
                                <span id="old_price_display">{if $productPriceWithoutReduction > $productPrice}{convertPrice price=$productPriceWithoutReduction}{/if}</span>
                                <!-- {if $accessory.tax_enabled && $display_tax_label == 1}{if $priceDisplay == 1}{l s='tax excl.' mod='belvg_popupcart'}{else}{l s='tax incl.' mod='belvg_popupcart'}{/if}{/if} -->
                            {/if}
                        </p>
                        {if $accessory.packItems|@count && $productPrice < $accessory.product->getNoPackPrice()}
                            <p class="pack_price">{l s='Instead of' mod='belvg_popupcart'} <span style="text-decoration: line-through;">{convertPrice price=$accessory.product->getNoPackPrice()}</span></p>
                            <br class="clear" />
                        {/if}
                        {if $accessory.product->ecotax != 0}
                            <p class="price-ecotax">{l s='Include' mod='belvg_popupcart'} <span id="ecotax_price_display">{if $priceDisplay == 2}{$accessory.ecotax_tax_exc|convertAndFormatPrice}{else}{$accessory.ecotax_tax_inc|convertAndFormatPrice}{/if}</span> {l s='For green tax' mod='belvg_popupcart'}
                                {if $accessory.product->specificPrice AND $accessory.product->specificPrice.reduction}
                                    <br />{l s='(not impacted by the discount)' mod='belvg_popupcart'}
                                {/if}
                            </p>
                        {/if}
                        {if !empty($accessory.product->unity) && $accessory.product->unit_price_ratio > 0.000000}
                            {math equation="pprice / punit_price"  pprice=$productPrice  punit_price=$accessory.product->unit_price_ratio assign=unit_price}
                            <p class="unit-price"><span id="unit_price_display">{convertPrice price=$unit_price}</span> {l s='per' mod='belvg_popupcart'} {$accessory.product->unity|escape:'htmlall':'UTF-8'}</p>
                        {/if}
                        {*close if for show price*}
                        {/if}
                            <p id="padd_to_cart" {if (!$accessory.allow_oosp && $accessory.product->quantity <= 0) OR !$accessory.product->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE}style="display:none"{/if} class="pbuttons_bottom_block">
                                <span></span>
                                <input type="submit" name="Submit" value="{l s='Add to cart' mod='belvg_popupcart'}" class="pexclusive" />
                            </p>
                        {if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}

                        <div class="clear"></div>
                    </div>
                    {if isset($accessory.images) && count($accessory.images) > 0}
                        <!-- thumbnails -->
                        <ul id="thumbs_list_frame">
                            {if isset($accessory.images)}
                                {foreach from=$accessory.images item=image name=thumbnails}
                                    {assign var=imageIds value="`$product->id`-`$image.id_image`"}
                                    <li id="thumbnail_{$image.id_image}">
                                        <a href="{$link->getImageLink($accessory.product->link_rewrite, $imageIds, 'thickbox_default')|escape:'html'}" rel="other-views" class="thickbox{if $smarty.foreach.thumbnails.first} shown{/if}" title="{$image.legend|htmlspecialchars}">
                                            <img id="thumb_{$image.id_image}" src="{$link->getImageLink($accessory.product->link_rewrite, $imageIds, 'medium_default')|escape:'html'}" alt="{$image.legend|htmlspecialchars}" height="{$mediumSize.height}" width="{$mediumSize.width}" />
                                        </a>
                                    </li>
                                {/foreach}
                            {/if}
                        </ul>

                    {/if}
                    <input type="hidden" name="token" value="{$static_token}" />
                    <input type="hidden" name="id_product" value="{$accessory.product->id|intval}" class="product_page_product_id" />
                    <input type="hidden" name="add" value="1" />
                    <input type="hidden" name="id_product_attribute" id="idCombination" value="" />
                </form>
            </div>
            {if ($smarty.foreach.accessories_list.index + 1) % 4==0 AND $smarty.foreach.accessories_list.index > 0}
                <div class="clear"></div>
            {/if}
            {/foreach}
            </div>
        </div>
    </div>
</div>
</div></div>
{/if}
<!-- /Block popupaddtocart -->