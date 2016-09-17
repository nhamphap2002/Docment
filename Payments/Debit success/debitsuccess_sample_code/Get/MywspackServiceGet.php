<?php
/**
 * Class file for MywspackServiceGet
 * @date 28/11/2012
 */
/**
 * Class MywspackServiceGet
 * @date 28/11/2012
 */
class MywspackServiceGet extends MywspackWsdlClass
{
	/**
	 * Method to call GetClientData
	 * Meta informations :
	 * 	- documentation : This function gets client information from the DebitSuccess system relating to any clients who have been loaded/edited/cancelled since the last call to this function
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypeGetClientData::getCustomerID()
	 * @uses MywspackTypeGetClientData::getCustomerCode()
	 * @param MywspackTypeGetClientData $_mywspackTypeGetClientData GetClientData
	 * @return MywspackTypeGetClientDataResponse
	 */
	public function GetClientData(MywspackTypeGetClientData $_mywspackTypeGetClientData)
	{
		try
		{
			$this->setResult(new MywspackTypeGetClientDataResponse(self::getSoapClient()->GetClientData(array('customerID'=>$_mywspackTypeGetClientData->getCustomerID(),'customerCode'=>$_mywspackTypeGetClientData->getCustomerCode()))));
		}
		catch(SoapFault $fault)
		{
			return !$this->saveLastError(__METHOD__,$fault);
		}
		return $this->getResult();
	}
	/**
	 * Method to call GetClientDataBetweenDates
	 * Meta informations :
	 * 	- documentation : This function gets client information from the DebitSuccess system relating to any clients who have been loaded/edited/cancelled between the dates supplied
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypeGetClientDataBetweenDates::getCustomerID()
	 * @uses MywspackTypeGetClientDataBetweenDates::getCustomerCode()
	 * @uses MywspackTypeGetClientDataBetweenDates::getStartDate()
	 * @uses MywspackTypeGetClientDataBetweenDates::getEndDate()
	 * @param MywspackTypeGetClientDataBetweenDates $_mywspackTypeGetClientDataBetweenDates GetClientDataBetweenDates
	 * @return MywspackTypeGetClientDataBetweenDatesResponse
	 */
	public function GetClientDataBetweenDates(MywspackTypeGetClientDataBetweenDates $_mywspackTypeGetClientDataBetweenDates)
	{
		try
		{
			$this->setResult(new MywspackTypeGetClientDataBetweenDatesResponse(self::getSoapClient()->GetClientDataBetweenDates(array('customerID'=>$_mywspackTypeGetClientDataBetweenDates->getCustomerID(),'customerCode'=>$_mywspackTypeGetClientDataBetweenDates->getCustomerCode(),'startDate'=>$_mywspackTypeGetClientDataBetweenDates->getStartDate(),'endDate'=>$_mywspackTypeGetClientDataBetweenDates->getEndDate()))));
		}
		catch(SoapFault $fault)
		{
			return !$this->saveLastError(__METHOD__,$fault);
		}
		return $this->getResult();
	}
	/**
	 * Method to call GetTransactionData
	 * Meta informations :
	 * 	- documentation : This function gets transaction information from the DebitSuccess system relating to any transactions that have occurred since the last call to this function
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypeGetTransactionData::getCustomerID()
	 * @uses MywspackTypeGetTransactionData::getCustomerCode()
	 * @param MywspackTypeGetTransactionData $_mywspackTypeGetTransactionData GetTransactionData
	 * @return MywspackTypeGetTransactionDataResponse
	 */
	public function GetTransactionData(MywspackTypeGetTransactionData $_mywspackTypeGetTransactionData)
	{
		try
		{
			$this->setResult(new MywspackTypeGetTransactionDataResponse(self::getSoapClient()->GetTransactionData(array('customerID'=>$_mywspackTypeGetTransactionData->getCustomerID(),'customerCode'=>$_mywspackTypeGetTransactionData->getCustomerCode()))));
		}
		catch(SoapFault $fault)
		{
			return !$this->saveLastError(__METHOD__,$fault);
		}
		return $this->getResult();
	}
	/**
	 * Method to call GetTransactionDataBetweenDates
	 * Meta informations :
	 * 	- documentation : This function gets transaction information from the DebitSuccess system relating to any transactions that occurred between the dates supplied
	 * @uses MywspackWsdlClass::getSoapClient()
	 * @uses MywspackWsdlClass::setResult()
	 * @uses MywspackWsdlClass::getResult()
	 * @uses MywspackWsdlClass::saveLastError()
	 * @uses MywspackTypeGetTransactionDataBetweenDates::getCustomerID()
	 * @uses MywspackTypeGetTransactionDataBetweenDates::getCustomerCode()
	 * @uses MywspackTypeGetTransactionDataBetweenDates::getStartDate()
	 * @uses MywspackTypeGetTransactionDataBetweenDates::getEndDate()
	 * @param MywspackTypeGetTransactionDataBetweenDates $_mywspackTypeGetTransactionDataBetweenDates GetTransactionDataBetweenDates
	 * @return MywspackTypeGetTransactionDataBetweenDatesResponse
	 */
	public function GetTransactionDataBetweenDates(MywspackTypeGetTransactionDataBetweenDates $_mywspackTypeGetTransactionDataBetweenDates)
	{
		try
		{
			$this->setResult(new MywspackTypeGetTransactionDataBetweenDatesResponse(self::getSoapClient()->GetTransactionDataBetweenDates(array('customerID'=>$_mywspackTypeGetTransactionDataBetweenDates->getCustomerID(),'customerCode'=>$_mywspackTypeGetTransactionDataBetweenDates->getCustomerCode(),'startDate'=>$_mywspackTypeGetTransactionDataBetweenDates->getStartDate(),'endDate'=>$_mywspackTypeGetTransactionDataBetweenDates->getEndDate()))));
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
	 * @return MywspackTypeGetClientDataResponse|MywspackTypeGetClientDataBetweenDatesResponse|MywspackTypeGetTransactionDataResponse|MywspackTypeGetTransactionDataBetweenDatesResponse
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