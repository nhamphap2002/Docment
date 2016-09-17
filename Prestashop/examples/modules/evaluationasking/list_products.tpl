<table width="100%" cellspacing="3" cellpadding="4" bordercolor="#c0c0c0" border="1" style="border-collapse: collapse; bo">
    <tr style="background:#f0f0f0">
        <th>&nbsp;</td>
        <th>{l s='Name'}</td>
        <th>{l s='Action'}</td>
    </tr>
    {foreach from=$datas item=data name=data_list}
        <tr>
            <td><img id="pbigpic" src="{$data.link_image|escape:'html'}" alt="{$data.legend|escape:'htmlall':'UTF-8'}"/></td>
            <td>{$data.name|escape:'htmlall':'UTF-8'}</td>
            <td><a href='{$data.link_review|escape:'htmlall':'UTF-8'}'>Review now</a></td>
        </tr>
    {/foreach}
</table>