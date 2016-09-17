<form method="post" action="" class="form-channel">
        <fieldset>
        <legend>{l s='Add rule' mod='fgcautoshare'}</legend>
  
        <label> {l s='Rule type' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <select name="autoshare_ruletype_id" class="autoshare_ruletype_id">
            {foreach from=$datas item='data'}
                <option value="{$data.id}">{$data.name} ({$data.expression})</option>
            {/foreach}
        </select>
        </div>

        <label> {l s='Channel' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <select name="autoshare_channel_id">
            {foreach from=$channels item='channel'}
                <option value="{$channel.id}">{$channel.name}</option>
            {/foreach}
        </select>
        </div>
        <label> {l s='Name' mod='fgcautoshare'}</label>
        <div class="margin-form"> <input name="name" size="40" type="text"/></div>
   
 
        <label> {l s='Condition' mod='fgcautoshare'}</label>
        <div class="margin-form"> <input name="condition" onkeyup="res(this, numb);"  class="condition" size="40" type="text"/>
            <span class="error_digital" style="color: Red; display: none"></span>
            <i id="cat">{l s='Category separated by commas (e.g: 1,2,3)' mod='fgcautoshare'}</i>
            
            <i id="cat1" style="display: inline">{l s='Price separated by dots (e.g: 40.666)' mod='fgcautoshare'}</i>
            
            
                <i id="cat2">{l s='Price separated by commas (e.g: 12,16)' mod='fgcautoshare'}</i>
        </div>
   
        <label>  {l s='Published' mod='fgcautoshare'}</label>
         <div class="margin-form"><select name="published">
            <option value="1">{l s='Yes' mod='fgcautoshare'}</option>
            <option value="0">{l s='No' mod='fgcautoshare'}</option>
        </select>
         </div>
  
         <div class="margin-form">
    <input type="submit" class="button" id="submit_rules" value="{l s='Save' mod='fgcautoshare'}" name="add_new_rule"/>
    <a class="button"  style="padding: 5px 8px;"  href="{$params.link_admin}&action=list_rules">{l s='Cancel' mod='fgcautoshare'}</a>
         </div>
         <div class="param_chanel">
            
         </div>
         
        
        </fieldset>
</form>