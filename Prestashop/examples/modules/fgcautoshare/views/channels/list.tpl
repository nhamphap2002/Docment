<script type="text/javascript">
    $(document).ready(function() {
        $("#check_all").click(function() {
            isCheck = this.checked;
            $("#tblchannels input:checkbox").attr("checked", function() {
                this.checked = isCheck;
            });

        });
    });
</script>
<fieldset>
    <legend>{l s='List of channels' mod='fgcautoshare'}</legend>
    <form action="" method="post">
        <p>
            <a class="button" href="{$params.link_admin}&action=add_channel">{l s='Add a new channel' mod='fgcautoshare'}</a>&nbsp;&nbsp;
            <input onclick="return confirm('{l s='Are you sure you want to delete this item?' mod='fgcautoshare'}');" class="button" type="submit" name="delete_channels" value="{l s='Delete channels' mod='fgcautoshare'}"/>
        </p>
        <div class="block_content">
            <table id="tblchannels" class="table" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="item">
                            <input type="checkbox" name="check_all" id="check_all"/>
                        </th>
                        <th class="item"><b>{l s='ID' mod='fgcautoshare'}</b></th>
                        <th style="width: 50%" class="item"><b>{l s='Name' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Channel type' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Status' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Published' mod='fgcautoshare'}</b></th>
                    </tr>
                </thead>
                <tbody>
                    {if $datas|@count gt 0}
                        {foreach from=$datas item='data'}
                            <tr class="alternate_item">
                                <td><input type="checkbox" name="channel_ids[]" value="{$data.id}" class="check_arr"/></td>
                                <td class="history_method">{$data.id}</td>
                                <td class="history_method"><u><a id="{$data.id}" class="name_chanel" href="{$params.link_admin}&action=edit_channel&channel_id={$data.id}">{$data.name|escape}</a></u></td>
                                <td class="history_method">{$data.channel_type_name|escape}</td>
                                <td class="history_method">{$data.status|escape}</td>
                                <td class="history_method">
                                    {if $data.published == 1}
                                        <p class="publish">{l s='Published' mod='fgcautoshare'}</p>
                                    {else}
                                        <p class="unpublish">{l s='UnPublished' mod='fgcautoshare'}</p>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td colspan="6"> {l s='No data' mod='fgcautoshare'}</td>
                        </tr>
                    {/if}
                </tbody>
            </table><br/>
            {if $datas|@count gt 0}
               {$paging}
            {/if}
        </div>

    </form>
</fieldset>