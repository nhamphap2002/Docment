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
*  @version  Release: $Revision: 7471 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<p>{l s='Your payment has been successful for order: %s' sprintf=$order_ref mod='sydneyecommerce'}
		<br /><br />
		{l s='Transaction Number: %s' sprintf=$trans_id mod='sydneyecommerce'}
		<br /><br />
		{l s='Receipt Number: %s' sprintf=$receipt_no mod='sydneyecommerce'}
		<br /><br />
		{l s='Total: ' mod='sydneyecommerce'}{displayPrice price=$total}
		<br /><br />
		{l s='We\'ll send a confirmation email to : %s' sprintf=$email mod='sydneyecommerce'}
		<br /><br />{l s='For any questions or for further information, please contact our' mod='sydneyecommerce'} <a href="{$link->getPageLink('contact', true)}">{l s='customer support' mod='sydneyecommerce'}</a>.
</p>