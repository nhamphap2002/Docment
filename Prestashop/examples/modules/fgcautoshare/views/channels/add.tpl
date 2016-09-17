<form method="post" action="" class="form-channel">
        <fieldset>
        <legend>{l s='Add channel' mod='fgcautoshare'}</legend>
  
        <label> {l s='Channel type' mod='fgcautoshare'}</label>
        <div class="margin-form" style="position: relative">
            <select name="autoshare_channeltype_id" class="autoshare_channeltype_id">
            {foreach from=$datas item='data'}
                <option value="{$data.id}" data_ajax="{$params.link_admin_ajax}?action=getParams&channel_id=0&channel_type_id={$data.id}">{$data.name}</option>
            {/foreach}
        </select><div class='loading'></div>
        </div>


        <label> {l s='Name' mod='fgcautoshare'}</label>
        <div class="margin-form"> <input name="name" size="40" type="text"/></div>
   
 
        <label> {l s='Description' mod='fgcautoshare'}</label>
        <div class="margin-form"><textarea name="description" cols="37" rows="3"></textarea></div>
   
  
        <label> {l s='Media mode' mod='fgcautoshare'}</label>
         <div class="margin-form">
        <select name="media_mode">
            <option value="message">{l s='Message' mod='fgcautoshare'}</option>
            <option value="attachment">{l s='Attachment' mod='fgcautoshare'}</option>
            <option value="both">{l s='Both' mod='fgcautoshare'}</option>
        </select>
         </div>   
   
<!--        <label>  {l s='Params' mod='fgcautoshare'}</label>
        <div class="margin-form"> <textarea name="params" cols="37" rows="3"></textarea></div>-->
   
   
        <label>  {l s='Published' mod='fgcautoshare'}</label>
         <div class="margin-form"><select name="published">
            <option value="1">{l s='Yes' mod='fgcautoshare'}</option>
            <option value="0">{l s='No' mod='fgcautoshare'}</option>
        </select>
         </div>
   
   
        <label> {l s='Auto publish' mod='fgcautoshare'}</label>
        <div class="margin-form">
            <select name="auto_publish">
            <option value="1">{l s='Yes' mod='fgcautoshare'}</option>
            <option value="0">{l s='No' mod='fgcautoshare'}</option>
        </select>
        </div>
  
         <div class="margin-form">
             <input type="hidden" name="status" value="" />
    <input type="submit" class="button" value="{l s='Save' mod='fgcautoshare'}" name="add_new_channel"/>
    <a class="button"  style="padding: 5px 8px;"  href="{$params.link_admin}">{l s='Cancel' mod='fgcautoshare'}</a>
         </div>
         <div class="param_chanel">
            
         </div>
         
        
        </fieldset>
</form>