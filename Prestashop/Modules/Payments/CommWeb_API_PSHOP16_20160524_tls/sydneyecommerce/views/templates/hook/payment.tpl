{*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 6844 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<p class="payment_module">
	<form name="sydneyecommerce_form" id="sydneyecommerce_form" action="#" method="post">
		<span style="border: 1px solid #dddddd;display: block;padding: 0.6em;text-decoration: none;width: 570px;">
			<a id="click_sydneyecommerce" href="#" title="{l s='Pay with Migs' mod='sydneyecommerce'}" style="display: block;text-decoration: none; font-weight: bold;">
				{$card_images}{l s='Secure Credit Card Payment' mod='sydneyecommerce'}
			</a>
			<div id="sydneyecommerce_card" style="display:none; position:relative;">
				<br /><br />
				<label for="sydneyecommerce_card_num" style="margin-top: 4px; margin-left: 35px; display: block; width: 120px; float: left;">{l s='Card number' mod='sydneyecommerce'}</label> <input type="text" name="sydneyecommerce_card_num" id="sydneyecommerce_card_num" size="30" maxlength="16" autocomplete="Off" style="width:200px;"/><br /><br />
				<label for="sydneyecommerce_exp_date_m" style="margin-top: 4px; margin-left: 35px; display: block; width: 120px; float: left;">{l s='Expiration date' mod='sydneyecommerce'}</label>
				<select id="sydneyecommerce_exp_date_m" name="sydneyecommerce_exp_date_m" style="width:60px;">{section name=date_m start=01 loop=13}
					<option value="{$smarty.section.date_m.index}">{$smarty.section.date_m.index}</option>{/section}
				</select>
				 /
				<select name="sydneyecommerce_exp_date_y" style="width:60px;">{section name=date_y start=0 loop=9}
					<option value="{'Y'|date + $smarty.section.date_y.index}">{'Y'|date + $smarty.section.date_y.index}</option>{/section}
				</select>
				<br class="clear" /><br/>
				<label for="sydneyecommerce_card_code" style="margin-top: 4px; margin-left: 35px; display: block; width: 120px; float: left;">{l s='Card CVV' mod='sydneyecommerce'}</label> <input type="text" name="sydneyecommerce_card_code" id="sydneyecommerce_card_code" size="4" maxlength="4" autocomplete="Off" style="width:60px;"/><img src="{$this_path}images/help.png" id="sydneyecommerce_cvv_help" title="{l s='the 3 last digits on the back of your credit card' mod='sydneyecommerce'}" alt="" /><br /><br />
			<img src="{$this_path}images/cvv.gif" id="sydneyecommerce_cvv_help_img" alt=""style="display: none;position:absolute; left:400px; top:40px;" />
			
				<input type="button" id="sydneyecommerce_submit" value="{l s='Submit Payment' mod='sydneyecommerce'}" style="margin-left: 129px; padding-left: 25px; padding-right: 25px; float: left;" class="button" />
				<br class="clear" />
				<br/>
				
			</div>
		</span>
	</form>
</p>
<script type="text/javascript">
	var mess_error = "{l s='Please check your credit card information (Credit card number and expiration date)' mod='sydneyecommerce' js=1}";
	var sydneyecommerce_validate_url = "{$link->getModuleLink('sydneyecommerce', 'validation', [], true)}";
	//var sydneyecommerce_validate_url = "{$this_path_ssl}validation";
	var loading_img = "{$this_path}images/loading.gif";
	{literal}
		$(document).ready(function(){
			$('#sydneyecommerce_exp_date_m').children('option').each(function()
			{
				if ($(this).val() < 10)
				{
					$(this).val('0' + $(this).val());
					$(this).html($(this).val())
				}
			});
			$('#click_sydneyecommerce').click(function(e){
				e.preventDefault();
				$('#click_sydneyecommerce').fadeOut("fast",function(){
					$("#sydneyecommerce_card").show();
					$('#click_sydneyecommerce').fadeIn('fast');
				});
				$('#click_sydneyecommerce').unbind();
				$('#click_sydneyecommerce').click(function(e){
					e.preventDefault();
				});
			});
			
			$('#sydneyecommerce_cvv_help').mouseover(function(){
				$("#sydneyecommerce_cvv_help_img").show();
			});
			$('#sydneyecommerce_cvv_help').mouseout(function(){
				$("#sydneyecommerce_cvv_help_img").hide();
			});

			$('#sydneyecommerce_submit').click(function()
				{
				if ($('#sydneyecommerce_card_num').val() == '' || $('#sydneyecommerce_card_code').val() == '')
				{
					alert(mess_error);
					return false;
				}

				$.ajax({
					url: sydneyecommerce_validate_url,
					type: 'post',
					data: $('#sydneyecommerce_form :input'),
					dataType: 'json',		
					beforeSend: function() {
						$('#sydneyecommerce_submit').attr('disabled', true);
						$('#sydneyecommerce_form').before('<div class="attention"><img src="'+loading_img+'" alt="" />Waiting...</div>');
					},
					complete: function() {
						$('#sydneyecommerce_submit').attr('disabled', false);
						$('.attention').remove();
					},				
					success: function(json) {
						if (json['error']) {
							alert(json['error']);
							return false;
						}
						
						if (json['success']) {
							location = json['success'];
						}
					}
				});
			});
		});

	{/literal}
</script>