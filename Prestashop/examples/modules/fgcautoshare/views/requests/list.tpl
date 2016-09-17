<script type="text/javascript">
    $(document).ready(function() {
        $("#check_all").click(function() {
            isCheck = this.checked;
            $("#tblrequests input:checkbox").attr("checked", function() {
                this.checked = isCheck;
            });

        });
    });
</script>
<fieldset>
    <legend>{l s='List of requests' mod='fgcautoshare'}</legend>
    <form action="" method="post">
        <p>
            <b>{l s='Url cronjob:' mod='fgcautoshare'}</b> <input class="link_cronjob" type="text" readonly="true" value="{$params.link_cronjob}"/>
        </p>
        <p>
            <input onclick="return confirm('{l s='Are you sure you want to process this item?' mod='fgcautoshare'}');" class="button" type="submit" name="process_to_queues" value="{l s='Process' mod='fgcautoshare'}"/>
            <input onclick="return confirm('{l s='Are you sure you want to delete this item?' mod='fgcautoshare'}');" class="button" type="submit" name="delete_requests" value="{l s='Delete requests' mod='fgcautoshare'}"/>
        </p>
        <div class="block_content">
            <table id="tblrequests" class="table" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="item">
                            <input type="checkbox" name="check_all" id="check_all"/>
                        </th>
                        <th class="item"><b>{l s='ID' mod='fgcautoshare'}</b></th>
                        <th style="width: 65%" class="item"><b>{l s='Name' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Created' mod='fgcautoshare'}</b></th>
                        <th class="item"><b>{l s='Processed' mod='fgcautoshare'}</b></th>
                    </tr>
                </thead>
                <tbody>
                    {if $datas|@count gt 0}
                        {foreach from=$datas item='data'}
                            <tr class="alternate_item">
                                <td><input type="checkbox" name="requests_ids[]" value="{$data.id}" id="check_arr"/></td>
                                <td class="history_method">{$data.id}</td>
                                <td class="history_method">{$data.product_name|escape}</td>
                                <td class="history_method">{$data.created|date_format:"%Y-%m-%d"}</td>
                                <td class="history_method">
                                    {if $data.published == 1}
                                        <p class="publish">{l s='Yes' mod='fgcautoshare'}</p>
                                    {else}
                                        <p class="unpublish">{l s='No' mod='fgcautoshare'}</p>
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