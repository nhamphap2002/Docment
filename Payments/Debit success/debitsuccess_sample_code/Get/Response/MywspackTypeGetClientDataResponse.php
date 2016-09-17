<?php
/**
 * Class file for MywspackTypeGetClientDataResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetClientDataResponse
 * @date 28/11/2012
 */
class MywspackTypeGetClientDataResponse extends MywspackWsdlClass
{
	/**
	 * The GetClientDataResult
	 * @var MywspackTypeGetClientDataResult
	 */
	public $GetClientDataResult;
	/**
	 * Constructor
	 * @param MywspackTypeGetClientDataResult $_getClientDataResult GetClientDataResult
	 * @return MywspackTypeGetClientDataResponse
	 */
	public function __construct($_getClientDataResult = null)
	{
		parent::__construct(array('GetClientDataResult'=>$_getClientDataResult));
	}
	/**
	 * Set GetClientDataResult
	 * @param MywspackTypeGetClientDataResult $_getClientDataResult GetClientDataResult
	 * @return MywspackTypeGetClientDataResult
	 */
	public function setGetClientDataResult($_getClientDataResult)
	{
		return ($this->GetClientDataResult = $_getClientDataResult);
	}
	/**
	 * Get GetClientDataResult
	 * @return MywspackTypeGetClientDataResult
	 */
	public function getGetClientDataResult()
	{
		return $this->GetClientDataResult;
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