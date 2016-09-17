<?php
/**
 * Class file for MywspackTypeClientXML
 * @date 28/11/2012
 */
/**
 * Class MywspackTypeClientXML
 * @date 28/11/2012
 */
class MywspackTypeClientXML extends MywspackWsdlClass
{
	/**
	 * The any
	 * @var DOMDocument
	 */
	public $any;
	/**
	 * Constructor
	 * @param DOMDocument $_any any
	 * @return MywspackTypeClientXML
	 */
	public function __construct($_any = null)
	{
   

		parent::__construct(array('any'=>$_any));
    $this->any = $_any;
   
	}
	/**
	 * Set any
	 * @param DOMDocument $_any any
	 * @return DOMDocument
	 */
	public function setAny($_any)
	{
		return ($this->any = $_any);
	}
	/**
	 * Get any
	 * @return DOMDocument
	 */
	public function getAny()
	{
		if(!($this->any instanceof DOMDocument))
		{
			$dom = new DOMDocument('1.0','UTF-8');
			$dom->formatOutput = true;
			$dom->loadXML($this->any);
			$this->setAny($dom);
		}
		return $this->any;
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