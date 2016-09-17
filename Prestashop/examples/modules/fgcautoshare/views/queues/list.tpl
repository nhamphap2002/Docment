<script type="text/javascript">
    $(document).ready(function() {
        $("#check_all").click(function() {
            isCheck = this.checked;
            $("#tblqueues input:checkbox").attr("checked", function() {
                this.checked = isCheck;
            });

        });
    });
</script>
<fieldset>
    <legend>{l s='List of posts' mod='fgcautoshare'}</legend>
    <form action="" method="post">
        <p>
            <input onclick="return confirm('{l s='Are you sure you want to delete this item?' mod='fgcautoshare'}');" class="button" type="submit" name="delete_queues" value="{l s='Delete posts' mod='fgcautoshare'}"/>
        </p>
        <div class="block_content">
            <table id="tblqueues" class="table" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="item">
                            <input type="checkbox" name="check_all" id="check_all"/>
                        </th>
                        <th class="item"><b>{l s='ID' mod='fgcautoshare'}</b></th>
                        <th style="width: 50%" class="item"><b>{l s='Title' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Channel' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Status' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Message' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Created' mod='fgcautoshare'}</b></th>
                    </tr>
                </thead>
                <tbody>
                    {if $datas|@count gt 0}
                        {foreach from=$datas item='data'}
                            <tr class="alternate_item">
                                <td><input type="checkbox" name="queues_ids[]" value="{$data.id}" id="check_arr"/></td>
                                <td class="history_method">{$data.id}</td>
                                <td class="history_method">{$data.title|escape}</td>
                                <td class="history_method">{$data.channel_name}</td>
                                <td class="history_method">{$data.status}</td>
                                <td class="history_method">{$data.message}</td>
                                <td class="history_method">{$data.created|date_format:"%Y-%m-%d"}</td>
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