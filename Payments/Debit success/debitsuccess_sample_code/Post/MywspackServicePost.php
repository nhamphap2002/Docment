<?php
/**
 * Class file for MywspackServicePost
 * @date 28/11/2012
 */
/**
 * Class MywspackServicePost
 * @date 28/11/2012
 */
class MywspackServicePost extends MywspackWsdlClass
{
	/**
	 * Method to call PostClientData
	 * Meta informations :
	 * 	- documentation : This function posts client information to the DebitSuccess system and returns xml outlining the operations performed (add/update/no change)
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypePostClientData::getCustomerID()
	 * @uses MywspackTypePostClientData::getCustomerCode()
	 * @uses MywspackTypePostClientData::getClientXML()
	 * @param MywspackTypePostClientData $_mywspackTypePostClientData PostClientData
	 * @return MywspackTypePostClientDataResponse
	 */
	public function PostClientData(MywspackTypePostClientData $_mywspackTypePostClientData)
	{
		try
		{
			$this->setResult(new MywspackTypePostClientDataResponse(self::getSoapClient()->PostClientData(array('customerID'=>$_mywspackTypePostClientData->getCustomerID(),'customerCode'=>$_mywspackTypePostClientData->getCustomerCode(),'clientXML'=>$_mywspackTypePostClientData->getClientXML()))));
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
	 * @return MywspackTypePostClientDataResponse
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