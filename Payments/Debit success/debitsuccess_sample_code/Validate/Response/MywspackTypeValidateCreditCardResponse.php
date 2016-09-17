<?php
/**
 * Class file for MywspackTypeValidateCreditCardResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeValidateCreditCardResponse
 * @date 28/11/2012
 */
class MywspackTypeValidateCreditCardResponse extends MywspackWsdlClass
{
	/**
	 * The ValidateCreditCardResult
	 * Meta informations :
	 * 	- minOccurs : 1
	 * 	- maxOccurs : 1
	 * @var boolean
	 */
	public $ValidateCreditCardResult;
	/**
	 * The validateFailReason
	 * Meta informations :
	 * 	- minOccurs : 0
	 * 	- maxOccurs : 1
	 * @var string
	 */
	public $validateFailReason;
	/**
	 * Constructor
	 * @param boolean $_validateCreditCardResult ValidateCreditCardResult
	 * @param string $_validateFailReason validateFailReason
	 * @return MywspackTypeValidateCreditCardResponse
	 */
	public function __construct($_validateCreditCardResult,$_validateFailReason = null)
	{
		parent::__construct(array('ValidateCreditCardResult'=>$_validateCreditCardResult,'validateFailReason'=>$_validateFailReason));
	}
	/**
	 * Set ValidateCreditCardResult
	 * @param boolean $_validateCreditCardResult ValidateCreditCardResult
	 * @return boolean
	 */
	public function setValidateCreditCardResult($_validateCreditCardResult)
	{
		return ($this->ValidateCreditCardResult = $_validateCreditCardResult);
	}
	/**
	 * Get ValidateCreditCardResult
	 * @return boolean
	 */
	public function getValidateCreditCardResult()
	{
		return $this->ValidateCreditCardResult;
	}
	/**
	 * Set validateFailReason
	 * @param string $_validateFailReason validateFailReason
	 * @return string
	 */
	public function setValidateFailReason($_validateFailReason)
	{
		return ($this->validateFailReason = $_validateFailReason);
	}
	/**
	 * Get validateFailReason
	 * @return string
	 */
	public function getValidateFailReason()
	{
		return $this->validateFailReason;
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