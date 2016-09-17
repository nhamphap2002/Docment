<?php
/**
 * Class file for MywspackServiceValidate
 * @date 28/11/2012
 */
/**
 * Class MywspackServiceValidate
 * @date 28/11/2012
 */
class MywspackServiceValidate extends MywspackWsdlClass
{
	/**
	 * Method to call ValidateCreditCard
	 * Meta informations :
	 * 	- documentation : This function validates the credit card details supplied
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypeValidateCreditCard::getCardType()
	 * @uses MywspackTypeValidateCreditCard::getCardNumber()
	 * @uses MywspackTypeValidateCreditCard::getValidateFailReason()
	 * @param MywspackTypeValidateCreditCard $_mywspackTypeValidateCreditCard ValidateCreditCard
	 * @return MywspackTypeValidateCreditCardResponse
	 */
	public function ValidateCreditCard(MywspackTypeValidateCreditCard $_mywspackTypeValidateCreditCard)
	{
		try
		{
			$this->setResult(new MywspackTypeValidateCreditCardResponse(self::getSoapClient()->ValidateCreditCard(array('cardType'=>$_mywspackTypeValidateCreditCard->getCardType(),'cardNumber'=>$_mywspackTypeValidateCreditCard->getCardNumber(),'validateFailReason'=>$_mywspackTypeValidateCreditCard->getValidateFailReason()))));
		}
		catch(SoapFault $fault)
		{
			return !$this->saveLastError(__METHOD__,$fault);
		}
		return $this->getResult();
	}
	/**
	 * Method returning the result content
	 *
	 * @return MywspackTypeValidateCreditCardResponse
	 */
	public function getResult()
	{
		return parent::getResult();
	}
	/**
	 * Method returning the class name
	 *
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
}
?>