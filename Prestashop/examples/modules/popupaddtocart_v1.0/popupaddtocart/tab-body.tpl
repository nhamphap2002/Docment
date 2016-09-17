<div id="ajax_choose_product">
    <p>
        <label>{l s='Search a product'}:</label>
        <input type="text" id="product_autocomplete_input" value="" autocomplete="off" class="ac_input">
        {l s='Begin typing the first letters of the product name, then select the product from the drop-down list.'}
    </p>
    <p>{l s='(Do not forget to save the product afterward)'}</p>
</div>
<div id="divAccessories">
    <p>
        <label>{l s='Products related'}:</label>
    <table>
        <tr>
            <td>{l s='Product name'}</td>
            <td>{l s='Action'}</td>
        </tr>
        {if isset($accessories) && count($accessories) > 0}
            {foreach from=$accessories item=accessory name=accessories_list}
                <tr>
                    <td>
                        <img id="pbigpic" src="{$link->getImageLink($accessory.link_rewrite, $accessory.id_image, 'medium_default')|escape:'html'}" alt="{$accessory.legend|escape:'htmlall':'UTF-8'}" width="{$mediumSize.width}" height="{$mediumSize.height}" />
                        {$accessory.name|escape:'htmlall':'UTF-8'}
                    </td>
                    <td>del</td>
                </tr>
            {/foreach}
        {else}
            <tr>
                <td colspan="2">{l s='No data'}</td>
            </tr>
        {/if}
    </table>
</p>
</div>