<?php
/**
 * Class file for MywspackTypePostClientData
 * @date 28/11/2012
 */
/**
 * Class MywspackTypePostClientData
 * @date 28/11/2012
 */
class MywspackTypePostClientData extends MywspackWsdlClass
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
	 * The clientXML
	 * @var MywspackTypeClientXML
	 */
	public $clientXML;
	/**
	 * Constructor
	 * @param string $_customerID customerID
	 * @param string $_customerCode customerCode
	 * @param MywspackTypeClientXML $_clientXML clientXML
	 * @return MywspackTypePostClientData
	 */
	public function __construct($_customerID = null,$_customerCode = null,$_clientXML = null)
	{
		parent::__construct(array('customerID'=>$_customerID,'customerCode'=>$_customerCode,'clientXML'=>$_clientXML));
    $this->clientXML=$_clientXML;
    $this->customerID = $_customerID;
    $this->customerCode=$_customerCode;
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
	 * Set clientXML
	 * @param MywspackTypeClientXML $_clientXML clientXML
	 * @return MywspackTypeClientXML
	 */
	public function setClientXML($_clientXML)
	{
		return ($this->clientXML = $_clientXML);
	}
	/**
	 * Get clientXML
	 * @return MywspackTypeClientXML
	 */
	public function getClientXML()
	{
		if(!($this->clientXML instanceof DOMDocument))
		{
			$dom = new DOMDocument('1.0','UTF-8');
			$dom->formatOutput = true;
			@$dom->loadXML($this->clientXML);
			$this->setClientXML($dom);
		}
    
		return $this->clientXML;
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