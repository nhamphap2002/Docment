<?php
/**
 * ClassMap 
 * @date 28/11/2012
 */
/**
 * ClassMap
 * @date 28/11/2012
 */
class MywspackClassMap
{
	/**
	 * Return the class map definition associating structs defined and structs generated. This array is sent to the SoapClient when calling the WS
	 * @return array
	 */
	final public static function classMap()
	{
		return array (
  'PostClientData' => 'MywspackTypePostClientData',
  'clientXML' => 'MywspackTypeClientXML',
  'PostClientDataResponse' => 'MywspackTypePostClientDataResponse',
  'PostClientDataResult' => 'MywspackTypePostClientDataResult',
  'GetClientData' => 'MywspackTypeGetClientData',
  'GetClientDataResponse' => 'MywspackTypeGetClientDataResponse',
  'GetClientDataResult' => 'MywspackTypeGetClientDataResult',
  'GetClientDataBetweenDates' => 'MywspackTypeGetClientDataBetweenDates',
  'GetClientDataBetweenDatesResponse' => 'MywspackTypeGetClientDataBetweenDatesResponse',
  'GetClientDataBetweenDatesResult' => 'MywspackTypeGetClientDataBetweenDatesResult',
  'GetTransactionData' => 'MywspackTypeGetTransactionData',
  'GetTransactionDataResponse' => 'MywspackTypeGetTransactionDataResponse',
  'GetTransactionDataResult' => 'MywspackTypeGetTransactionDataResult',
  'GetTransactionDataBetweenDates' => 'MywspackTypeGetTransactionDataBetweenDates',
  'GetTransactionDataBetweenDatesResponse' => 'MywspackTypeGetTransactionDataBetweenDatesResponse',
  'GetTransactionDataBetweenDatesResult' => 'MywspackTypeGetTransactionDataBetweenDatesResult',
  'ValidateCreditCard' => 'MywspackTypeValidateCreditCard',
  'ValidateCreditCardResponse' => 'MywspackTypeValidateCreditCardResponse',
);
	}
}
?>