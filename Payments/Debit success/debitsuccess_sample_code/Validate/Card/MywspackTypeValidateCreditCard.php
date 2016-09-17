<?php
/**
 * Class file for MywspackTypeValidateCreditCard
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeValidateCreditCard
 * @date 28/11/2012
 */
class MywspackTypeValidateCreditCard extends MywspackWsdlClass
{
	/**
	 * The cardType
	 * Meta informations :
	 * 	- minOccurs : 0
	 * 	- maxOccurs : 1
	 * @var string
	 */
	public $cardType;
	/**
	 * The cardNumber
	 * Meta informations :
	 * 	- minOccurs : 0
	 * 	- maxOccurs : 1
	 * @var string
	 */
	public $cardNumber;
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
	 * @param string $_cardType cardType
	 * @param string $_cardNumber cardNumber
	 * @param string $_validateFailReason validateFailReason
	 * @return MywspackTypeValidateCreditCard
	 */
	public function __construct($_cardType = null,$_cardNumber = null,$_validateFailReason = null)
	{
		parent::__construct(array('cardType'=>$_cardType,'cardNumber'=>$_cardNumber,'validateFailReason'=>$_validateFailReason));
	}
	/**
	 * Set cardType
	 * @param string $_cardType cardType
	 * @return string
	 */
	public function setCardType($_cardType)
	{
		return ($this->cardType = $_cardType);
	}
	/**
	 * Get cardType
	 * @return string
	 */
	public function getCardType()
	{
		return $this->cardType;
	}
	/**
	 * Set cardNumber
	 * @param string $_cardNumber cardNumber
	 * @return string
	 */
	public function setCardNumber($_cardNumber)
	{
		return ($this->cardNumber = $_cardNumber);
	}
	/**
	 * Get cardNumber
	 * @return string
	 */
	public function getCardNumber()
	{
		return $this->cardNumber;
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