<?php
/**
 * Class file for MywspackTypeGetClientDataBetweenDates
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetClientDataBetweenDates
 * @date 28/11/2012
 */
class MywspackTypeGetClientDataBetweenDates extends MywspackWsdlClass
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
	 * The startDate
	 * Meta informations :
	 * 	- minOccurs : 1
	 * 	- maxOccurs : 1
	 * @var dateTime
	 */
	public $startDate;
	/**
	 * The endDate
	 * Meta informations :
	 * 	- minOccurs : 1
	 * 	- maxOccurs : 1
	 * @var dateTime
	 */
	public $endDate;
	/**
	 * Constructor
	 * @param string $_customerID customerID
	 * @param string $_customerCode customerCode
	 * @param dateTime $_startDate startDate
	 * @param dateTime $_endDate endDate
	 * @return MywspackTypeGetClientDataBetweenDates
	 */
	public function __construct($_customerID = null,$_customerCode = null,$_startDate,$_endDate)
	{
		parent::__construct(array('customerID'=>$_customerID,'customerCode'=>$_customerCode,'startDate'=>$_startDate,'endDate'=>$_endDate));
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
	 * Set startDate
	 * @param dateTime $_startDate startDate
	 * @return dateTime
	 */
	public function setStartDate($_startDate)
	{
		return ($this->startDate = $_startDate);
	}
	/**
	 * Get startDate
	 * @return dateTime
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}
	/**
	 * Set endDate
	 * @param dateTime $_endDate endDate
	 * @return dateTime
	 */
	public function setEndDate($_endDate)
	{
		return ($this->endDate = $_endDate);
	}
	/**
	 * Get endDate
	 * @return dateTime
	 */
	public function getEndDate()
	{
		return $this->endDate;
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