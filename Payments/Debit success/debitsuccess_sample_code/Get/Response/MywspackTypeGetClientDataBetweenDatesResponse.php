<?php
/**
 * Class file for MywspackTypeGetClientDataBetweenDatesResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeGetClientDataBetweenDatesResponse
 * @date 28/11/2012
 */
class MywspackTypeGetClientDataBetweenDatesResponse extends MywspackWsdlClass
{
	/**
	 * The GetClientDataBetweenDatesResult
	 * @var MywspackTypeGetClientDataBetweenDatesResult
	 */
	public $GetClientDataBetweenDatesResult;
	/**
	 * Constructor
	 * @param MywspackTypeGetClientDataBetweenDatesResult $_getClientDataBetweenDatesResult GetClientDataBetweenDatesResult
	 * @return MywspackTypeGetClientDataBetweenDatesResponse
	 */
	public function __construct($_getClientDataBetweenDatesResult = null)
	{
		parent::__construct(array('GetClientDataBetweenDatesResult'=>$_getClientDataBetweenDatesResult));
	}
	/**
	 * Set GetClientDataBetweenDatesResult
	 * @param MywspackTypeGetClientDataBetweenDatesResult $_getClientDataBetweenDatesResult GetClientDataBetweenDatesResult
	 * @return MywspackTypeGetClientDataBetweenDatesResult
	 */
	public function setGetClientDataBetweenDatesResult($_getClientDataBetweenDatesResult)
	{
		return ($this->GetClientDataBetweenDatesResult = $_getClientDataBetweenDatesResult);
	}
	/**
	 * Get GetClientDataBetweenDatesResult
	 * @return MywspackTypeGetClientDataBetweenDatesResult
	 */
	public function getGetClientDataBetweenDatesResult()
	{
		return $this->GetClientDataBetweenDatesResult;
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