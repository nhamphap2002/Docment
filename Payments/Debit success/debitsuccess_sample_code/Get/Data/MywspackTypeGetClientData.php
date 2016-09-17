<?php
/**
 * Class file for MywspackTypeGetClientData
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetClientData
 * @date 28/11/2012
 */
class MywspackTypeGetClientData extends MywspackWsdlClass
{
	/**
	 * The customerID
	 * Meta informations :
	 * 	- minOccurs : 0
	 * 	- maxOccurs : 1
	 * @var string
	 */
	public $customerID;
	/**
	 * The customerCode
	 * Meta informations :
	 * 	- minOccurs : 0
	 * 	- maxOccurs : 1
	 * @var string
	 */
	public $customerCode;
	/**
	 * Constructor
	 * @param string $_customerID customerID
	 * @param string $_customerCode customerCode
	 * @return MywspackTypeGetClientData
	 */
	public function __construct($_customerID = null,$_customerCode = null)
	{
		parent::__construct(array('customerID'=>$_customerID,'customerCode'=>$_customerCode));
	}
	/**
	 * Set customerID
	 * @param string $_customerID customerID
	 * @return string
	 */
	public function setCustomerID($_customerID)
	{
		return ($this->customerID = $_customerID);
	}
	/**
	 * Get customerID
	 * @return string
	 */
	public function getCustomerID()
	{
		return $this->customerID;
	}
	/**
	 * Set customerCode
	 * @param string $_customerCode customerCode
	 * @return string
	 */
	public function setCustomerCode($_customerCode)
	{
		return ($this->customerCode = $_customerCode);
	}
	/**
	 * Get customerCode
	 * @return string
	 */
	public function getCustomerCode()
	{
		return $this->customerCode;
	}
	/**
	 * Method returning the class name
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
}
?>