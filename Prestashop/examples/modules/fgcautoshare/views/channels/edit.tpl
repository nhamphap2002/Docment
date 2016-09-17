  
<form method="post" action="" class="form-channel">
    <fieldset>
      <legend>{l s='Edit channel' mod='fgcautoshare'}</legend>
   
      <label>  {l s='Channel type' mod='fgcautoshare'}</label>
           <div class="margin-form">  <select name="autoshare_channeltype_id" class="autoshare_channeltype_id">
            {foreach from=$datas item='type'}
                <option  data_ajax="{$params.link_admin_ajax}?action=getParams&channel_id={$info.id}&channel_type_id={$type.id}" {if $info.autoshare_channeltype_id == $type.id} selected="true" {/if} value="{$type.id}">{$type.name}</option>
            {/foreach}
        </select>
           </div>
        
  
            <label>{l s='Name' mod='fgcautoshare'}</label>
            <div class="margin-form">
                <input name="name" type="text" size="40" value="{$info.name}"/>
            </div>
  
                <label> {l s='Description' mod='fgcautoshare'}</label>
                <div class="margin-form">
                    <textarea name="description" cols="37" rows="3">{$info.description}</textarea>
                </div>
  
                    <label>{l s='Media mode' mod='fgcautoshare'}</label>
                         <div class="margin-form">
        <select name="media_mode">
            <option {if $info.media_mode == 'message'} selected="true" {/if} value="message">{l s='Message' mod='fgcautoshare'}</option>
            <option {if $info.media_mode == 'attachment'} selected="true" {/if} value="attachment">{l s='Attachment' mod='fgcautoshare'}</option>
            <option {if $info.media_mode == 'both'} selected="true" {/if} value="both">{l s='Both' mod='fgcautoshare'}</option>
        </select>
                         </div>
 
<!--        <label> {l s='Params' mod='fgcautoshare'}</label>
             <div class="margin-form">
        <textarea name="params" cols="37" rows="3">{$info.params}</textarea>
             </div>-->
    
        <label>{l s='Published' mod='fgcautoshare'}</label>
             <div class="margin-form">
        <select name="published">
            <option {if $info.published == '1'} selected="true" {/if} value="1">{l s='Yes' mod='fgcautoshare'}</option>
            <option {if $info.published == '0'} selected="true" {/if} value="0">{l s='No' mod='fgcautoshare'}</option>
        </select>
             </div>
            <label>{l s='Auto publish' mod='fgcautoshare'}</label>
                 <div class="margin-form">
        <select name="auto_publish">
            <option {if $info.auto_publish == '1'} selected="true" {/if} value="1">{l s='Yes' mod='fgcautoshare'}</option>
            <option {if $info.auto_publish == '0'} selected="true" {/if}  value="0">{l s='No' mod='fgcautoshare'}</option>
        </select>
                 </div>
             <div class="margin-form">
   
    <input type="submit"  class="button" value="{l s='Save' mod='fgcautoshare'}" name="update_channel"/>
    <input type="hidden" name="id" value="{$info.id}"/>
    <a class="button" style="padding: 5px 8px;"  href="{$params.link_admin}">{l s='Cancel' mod='fgcautoshare'}</a>
             </div>
               <div class="param_chanel"></div>
    </fieldset>
</form>