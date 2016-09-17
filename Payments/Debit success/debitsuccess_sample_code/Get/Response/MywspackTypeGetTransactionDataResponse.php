<?php
/**
 * Class file for MywspackTypeGetTransactionDataResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetTransactionDataResponse
 * @date 28/11/2012
 */
class MywspackTypeGetTransactionDataResponse extends MywspackWsdlClass
{
	/**
	 * The GetTransactionDataResult
	 * @var MywspackTypeGetTransactionDataResult
	 */
	public $GetTransactionDataResult;
	/**
	 * Constructor
	 * @param MywspackTypeGetTransactionDataResult $_getTransactionDataResult GetTransactionDataResult
	 * @return MywspackTypeGetTransactionDataResponse
	 */
	public function __construct($_getTransactionDataResult = null)
	{
		parent::__construct(array('GetTransactionDataResult'=>$_getTransactionDataResult));
	}
	/**
	 * Set GetTransactionDataResult
	 * @param MywspackTypeGetTransactionDataResult $_getTransactionDataResult GetTransactionDataResult
	 * @return MywspackTypeGetTransactionDataResult
	 */
	public function setGetTransactionDataResult($_getTransactionDataResult)
	{
		return ($this->GetTransactionDataResult = $_getTransactionDataResult);
	}
	/**
	 * Get GetTransactionDataResult
	 * @return MywspackTypeGetTransactionDataResult
	 */
	public function getGetTransactionDataResult()
	{
		return $this->GetTransactionDataResult;
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