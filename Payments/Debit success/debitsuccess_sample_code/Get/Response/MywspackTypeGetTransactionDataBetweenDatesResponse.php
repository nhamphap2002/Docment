<?php
/**
 * Class file for MywspackTypeGetTransactionDataBetweenDatesResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetTransactionDataBetweenDatesResponse
 * @date 28/11/2012
 */
class MywspackTypeGetTransactionDataBetweenDatesResponse extends MywspackWsdlClass
{
	/**
	 * The GetTransactionDataBetweenDatesResult
	 * @var MywspackTypeGetTransactionDataBetweenDatesResult
	 */
	public $GetTransactionDataBetweenDatesResult;
	/**
	 * Constructor
	 * @param MywspackTypeGetTransactionDataBetweenDatesResult $_getTransactionDataBetweenDatesResult GetTransactionDataBetweenDatesResult
	 * @return MywspackTypeGetTransactionDataBetweenDatesResponse
	 */
	public function __construct($_getTransactionDataBetweenDatesResult = null)
	{
		parent::__construct(array('GetTransactionDataBetweenDatesResult'=>$_getTransactionDataBetweenDatesResult));
	}
	/**
	 * Set GetTransactionDataBetweenDatesResult
	 * @param MywspackTypeGetTransactionDataBetweenDatesResult $_getTransactionDataBetweenDatesResult GetTransactionDataBetweenDatesResult
	 * @return MywspackTypeGetTransactionDataBetweenDatesResult
	 */
	public function setGetTransactionDataBetweenDatesResult($_getTransactionDataBetweenDatesResult)
	{
		return ($this->GetTransactionDataBetweenDatesResult = $_getTransactionDataBetweenDatesResult);
	}
	/**
	 * Get GetTransactionDataBetweenDatesResult
	 * @return MywspackTypeGetTransactionDataBetweenDatesResult
	 */
	public function getGetTransactionDataBetweenDatesResult()
	{
		return $this->GetTransactionDataBetweenDatesResult;
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