<?php
/**
 * Class file for MywspackTypePostClientDataResponse
 * @date 28/11/2012
 */
/**
 * Class MywspackTypePostClientDataResponse
 * @date 28/11/2012
 */
class MywspackTypePostClientDataResponse extends MywspackWsdlClass
{
	/**
	 * The PostClientDataResult
	 * @var MywspackTypePostClientDataResult
	 */
	public $PostClientDataResult;
	/**
	 * Constructor
	 * @param MywspackTypePostClientDataResult $_postClientDataResult PostClientDataResult
	 * @return MywspackTypePostClientDataResponse
	 */
	public function __construct($_postClientDataResult = null)
	{
		parent::__construct(array('PostClientDataResult'=>$_postClientDataResult));
	}
	/**
	 * Set PostClientDataResult
	 * @param MywspackTypePostClientDataResult $_postClientDataResult PostClientDataResult
	 * @return MywspackTypePostClientDataResult
	 */
	public function setPostClientDataResult($_postClientDataResult)
	{
		return ($this->PostClientDataResult = $_postClientDataResult);
	}
	/**
	 * Get PostClientDataResult
	 * @return MywspackTypePostClientDataResult
	 */
	public function getPostClientDataResult()
	{
		return $this->PostClientDataResult;
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