  
<form method="post" action="" class="form-channel">
    <fieldset>
        <legend>{l s='Edit rule' mod='fgcautoshare'}</legend>

        <label>  {l s='Rule type' mod='fgcautoshare'}</label>
        <div class="margin-form">  
            <select name="autoshare_ruletype_id" class=autoshare_ruletype_id>
                {foreach from=$datas item='type'}
                    <option {if $info.autoshare_ruletype_id == $type.id} selected="true" {/if} value="{$type.id}">{$type.name} ({$type.expression})</option>
                {/foreach}
            </select>
        </div>

        <label> {l s='Channel' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <select name="autoshare_channel_id">
                {foreach from=$channels item='channel'}
                    <option {if $info.autoshare_channel_id == $channel.id} selected="true" {/if} value="{$channel.id}">{$channel.name}</option>
                {/foreach}
            </select>
        </div>

        <label>{l s='Name' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <input name="name" type="text" size="40" value="{$info.name}"/>
        </div>

        <label> {l s='Condition' mod='fgcautoshare'}</label>
        <div class="margin-form"> <input name="condition" size="40" {if $info.autoshare_ruletype_id == 4 ||$info.autoshare_ruletype_id==5}onkeyup="res(this, numb2);" {else}onkeyup="res(this, numb);" {/if} class="condition" value="{$info.condition}" type="text"/>  <span class="error_digital" style="color: Red; display: none"></span>
           
                <i  {if $info.autoshare_ruletype_id == 1 ||$info.autoshare_ruletype_id==2}style="display: inline;"{/if}id="cat1">{l s='Price separated by dots (e.g: 40.666)' mod='fgcautoshare'}</i>
            
            
                <i {if $info.autoshare_ruletype_id == 3}style="display: inline;"{/if}id="cat2">{l s='Price separated by commas (e.g: 12,16)' mod='fgcautoshare'}</i>
            
            <i {if $info.autoshare_ruletype_id == 4 ||$info.autoshare_ruletype_id==5} style="display: inline;"{/if} id="cat">{l s='Category separated by commas (e.g: 1,2,3)' mod='fgcautoshare'}</i></div>

        <label>{l s='Published' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <select name="published">
                <option {if $info.published == '1'} selected="true" {/if} value="1">{l s='Yes' mod='fgcautoshare'}</option>
                <option {if $info.published == '0'} selected="true" {/if} value="0">{l s='No' mod='fgcautoshare'}</option>
            </select>
        </div>

        <div class="margin-form">

            <input type="submit"  class="button" id="submit_rules" value="{l s='Save' mod='fgcautoshare'}" name="update_rule"/>
            <input type="hidden" name="id" value="{$info.id}"/>
            <a class="button" style="padding: 5px 8px;"  href="{$params.link_admin}&action=list_rules">{l s='Cancel' mod='fgcautoshare'}</a>
        </div>
        <div class="param_chanel"></div>
    </fieldset>
</form>