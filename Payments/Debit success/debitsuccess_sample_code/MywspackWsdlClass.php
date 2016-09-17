<?php
/**
 * File for MywspackWsdlClass to communicate with SOAP service
 * @date 28/11/2012
 */
/**
 * File for MywspackWsdlClass to communicate with SOAP service
 * Documentation : This web service allows customers to share client and transaction information with DebitSuccess
 * @date 28/11/2012
 */
class MywspackWsdlClass extends stdClass implements ArrayAccess,Iterator,Countable
{
	/**
	 * Option key to define WSDL url
	 * @var string
	 */
	const WSDL_URL = 'wsdl_url';
	/**
	 * Option key to define WSDL login
	 * @var string
	 */
	const WSDL_LOGIN = 'wsdl_login';
	/**
	 * Option key to define WSDL password
	 * @var string
	 */
	const WSDL_PASSWD = 'wsdl_password';
	/**
	 * Option key to define WSDL trace option
	 * @var string
	 */
	const WSDL_TRACE = 'wsdl_trace';
	/**
	 * Option key to define WSDL exceptions
	 * @var string
	 */
	const WSDL_EXCPTS = 'wsdl_exceptions';
	/**
	 * Option key to define WSDL cache_wsdl
	 * @var string
	 */
	const WSDL_CACHE_WSDL = 'wsdl_cache_wsdl';
	/**
	 * Option key to define WSDL stream_context
	 * @var string
	 */
	const WSDL_STREAM_CONTEXT = 'wsdl_stream_context';
	/**
	 * Option key to define WSDL soap_version
	 * @var string
	 */
	const WSDL_SOAP_VERSION = 'wsdl_soap_version';
	/**
	 * Option key to define WSDL compression
	 * @var string
	 */
	const WSDL_COMPRESSION = 'wsdl_compression';
	/**
	 * Option key to define WSDL encoding
	 * @var string
	 */
	const WSDL_ENCODING = 'wsdl_encoding';
	/**
	 * Option key to define WSDL connection_timeout
	 * @var string
	 */
	const WSDL_CONNECTION_TIMEOUT = 'wsdl_connection_timeout';
	/**
	 * Option key to define WSDL typemap
	 * @var string
	 */
	const WSDL_TYPEMAP = 'wsdl_typemap';
	/**
	 * Option key to define WSDL user_agent
	 * @var string
	 */
	const WSDL_USER_AGENT = 'wsdl_user_agent';
	/**
	 * Option key to define WSDL features
	 * @var string
	 */
	const WSDL_FEATURES = 'wsdl_features';
	/**
	 * Option key to define WSDL keep_alive
	 * @var string
	 */
	const WSDL_FKEEP_ALIVE = 'wsdl_keep_alive';
	/**
	 * Soapclient called to communicate with the actual SOAP Service
	 * @var SoapClient
	 */
	private static $soapClient;
	/**
	 * Contains Soap call result
	 * @var mixed
	 */
	private $result;
	/**
	 * Contains last errors
	 * @var array
	 */
	private $lastError;
	/**
	 * Array that contains values when only one parameter is set when calling __construct method
	 * @var array
	 */
	private $internArrayToIterate;
	/**
	 * Bool that tells if array is set or not
	 * @var bool
	 */
	private $internArrayToIterateIsArray;
	/**
	 * Items index browser
	 * @var int
	 */
	private $internArrayToIterateOffset;
	/**
	 * Constructor
	 * @uses MywspackWsdlClass::setLastError()
	 * @uses MywspackWsdlClass::initSoapClient()
	 * @uses MywspackWsdlClass::initInternArrayToIterate()
	 * @uses MywspackWsdlClass::_set()
	 * @param array $_arrayOfValues values
	 * @return Lists
	 */
	public function __construct($_arrayOfValues = array())
	{
		$this->setLastError(array());
		/**
		 * Init soap Client
		 * Set default values
		 */
		$this->initSoapClient($_arrayOfValues);
		/**
		 * Init array of values if set
		 */
		$this->initInternArrayToIterate($_arrayOfValues);
		/**
		 * Generic set methods
		 */
		if(is_array($_arrayOfValues) && count($_arrayOfValues))
		{
			foreach($_arrayOfValues as $name=>$value)
				$this->_set($name,$value);
		}
	}
	/**
	 * Static method getting current SoapClient
	 * @return SoapClient
	 */
	public static function getSoapClient()
	{
		return self::$soapClient;
	}
	/**
	 * Static method setting current SoapClient
	 * @param SoapClient $_soapClient
	 * @return SoapClient
	 */
	protected static function setSoapClient(SoapClient $_soapClient)
	{
		return (self::$soapClient = $_soapClient);
	}
	/**
	 * Method initiating SoapClient
	 * @uses MywspackWsdlClass::classMap()
	 * @uses MywspackWsdlClass::getDefaultWsdlOptions()
	 * @param array $_wsdlOptions WSDL options
	 * @return void
	 */
	public function initSoapClient($_wsdlOptions)
	{
		if(class_exists('MywspackClassMap',true))
		{
			$wsdlOptions = array();
			$wsdlOptions['classmap'] = MywspackClassMap::classMap();
			$defaultWsdlOptions = self::getDefaultWsdlOptions();
			foreach($defaultWsdlOptions as $optioName=>$optionValue)
			{
				if(array_key_exists($optioName,$_wsdlOptions) && !empty($_wsdlOptions[$optioName]))
					$wsdlOptions[str_replace('wsdl_','',$optioName)] = $_wsdlOptions[$optioName];
				elseif(!empty($optionValue))
					$wsdlOptions[str_replace('wsdl_','',$optioName)] = $optionValue;
			}
			if(array_key_exists(str_replace('wsdl_','',self::WSDL_URL),$wsdlOptions))
			{
				$wsdlUrl = $wsdlOptions[str_replace('wsdl_','',self::WSDL_URL)];
				unset($wsdlOptions[str_replace('wsdl_','',self::WSDL_URL)]);
				self::setSoapClient(new SoapClient($wsdlUrl,$wsdlOptions));
			}
		}
	}
	/**
	 * Method returning all default options values
	 * @uses MywspackWsdlClass::WSDL_CACHE_WSDL
	 * @uses MywspackWsdlClass::WSDL_COMPRESSION
	 * @uses MywspackWsdlClass::WSDL_CONNECTION_TIMEOUT
	 * @uses MywspackWsdlClass::WSDL_ENCODING
	 * @uses MywspackWsdlClass::WSDL_EXCPTS
	 * @uses MywspackWsdlClass::WSDL_FEATURES
	 * @uses MywspackWsdlClass::WSDL_LOGIN
	 * @uses MywspackWsdlClass::WSDL_PASSWD
	 * @uses MywspackWsdlClass::WSDL_SOAP_VERSION
	 * @uses MywspackWsdlClass::WSDL_STREAM_CONTEXT
	 * @uses MywspackWsdlClass::WSDL_TRACE
	 * @uses MywspackWsdlClass::WSDL_TYPEMAP
	 * @uses MywspackWsdlClass::WSDL_URL
	 * @uses MywspackWsdlClass::WSDL_USER_AGENT
	 * @return array
	 */
	public static function getDefaultWsdlOptions()
	{
		return array(
					self::WSDL_CACHE_WSDL=>WSDL_CACHE_NONE,
					self::WSDL_COMPRESSION=>null,
					self::WSDL_CONNECTION_TIMEOUT=>null,
					self::WSDL_ENCODING=>null,
					self::WSDL_EXCPTS=>true,
					self::WSDL_FEATURES=>null,
					self::WSDL_LOGIN=>null,
					self::WSDL_PASSWD=>null,
					self::WSDL_SOAP_VERSION=>null,
					self::WSDL_STREAM_CONTEXT=>null,
					self::WSDL_TRACE=>true,
					self::WSDL_TYPEMAP=>null,
					self::WSDL_URL=>null,
					self::WSDL_USER_AGENT=>null);
	}
	/**
	 * Method alias to count
	 * @uses MywspackWsdlClass::count()
	 * @return int
	 */
	public function length()
	{
		return $this->count();
	}
	/**
	 * Method returning item length, alias to length
	 * @uses MywspackWsdlClass::internArrayToIterateIsArray()
	 * @uses MywspackWsdlClass::getInternArrayToIterate()
	 * @return int
	 */
	public function count()
	{
		return $this->getInternArrayToIterateIsArray()?count($this->getInternArrayToIterate()):-1;
	}
	/**
	 * Method returning the current element
	 * @uses MywspackWsdlClass::offsetGet()
	 * @return mixed
	 */
	public function current()
	{
		return $this->offsetGet($this->internArrayToIterateOffset);
	}
	/**
	 * Method moving the current position to the next element
	 * @uses MywspackWsdlClass::getInternArrayToIterateOffset()
	 * @uses MywspackWsdlClass::setInternArrayToIterateOffset()
	 * @return int
	 */
	public function next()
	{
		return $this->setInternArrayToIterateOffset($this->getInternArrayToIterateOffset() + 1);
	}
	/**
	 * Method resetting itemOffset
	 * @uses MywspackWsdlClass::setInternArrayToIterateOffset()
	 * @return int
	 */
	public function rewind()
	{
		return $this->setInternArrayToIterateOffset(0);
	}
	/**
	 * Method checking if current itemOffset points to an existing item
	 * @uses MywspackWsdlClass::getInternArrayToIterateOffset()
	 * @uses MywspackWsdlClass::offsetExists()
	 * @return bool true|false
	 */
	public function valid()
	{
		return $this->offsetExists($this->getInternArrayToIterateOffset());
	}
	/**
	 * Method returning current itemOffset value, alias to getInternArrayToIterateOffset
	 * @uses MywspackWsdlClass::getInternArrayToIterateOffset()
	 * @return int
	 */
	public function key()
	{
		return $this->getInternArrayToIterateOffset();
	}
	/**
	 * Method alias to offsetGet
	 * @see MywspackWsdlClass::offsetGet()
	 * @uses MywspackWsdlClass::offsetGet()
	 * @param int
	 * @return mixed
	 */
	public function item($_index)
	{
		return $this->offsetGet($_index);
	}
	/**
	 * Default method adding item to array
	 * @uses MywspackWsdlClass::getAttributeName()
	 * @uses MywspackWsdlClass::__toString()
	 * @uses MywspackWsdlClass::_set()
	 * @uses MywspackWsdlClass::_get()
	 * @uses MywspackWsdlClass::setInternArrayToIterate()
	 * @uses MywspackWsdlClass::setInternArrayToIterateIsArray()
	 * @uses MywspackWsdlClass::setInternArrayToIterateOffset()
	 * @param mixed $_item value
	 * @return bool true|false
	 */
	public function add($_item)
	{
		if($this->getAttributeName() != '' && strpos($this->__toString(),'ArrayOf') !== false)
		{
			/**
			 * init array
			 */
			if(!is_array($this->_get($this->getAttributeName())))
				$this->_set($this->getAttributeName(),array());
			/**
			 * current array
			 */
			$currentArray = $this->_get($this->getAttributeName());
			array_push($currentArray,$_item);
			$this->_set($this->getAttributeName(),$currentArray);
			$this->setInternArrayToIterate($currentArray);
			$this->setInternArrayToIterateIsArray(true);
			$this->setInternArrayToIterateOffset(0);
			return true;
		}
		return false;
	}
	/**
	 * Method to call when sending data to request for ArrayOf type class
	 * @uses MywspackWsdlClass::getAttributeName()
	 * @uses MywspackWsdlClass::__toString()
	 * @uses MywspackWsdlClass::_get()
	 * @return mixed
	 */
	public function toSend()
	{
		if($this->getAttributeName() != '' && strpos($this->__toString(),'ArrayOf') !== false)
			return $this->_get($this->getAttributeName());
		else
			return null;
	}
	/**
	 * Method returning the first item
	 * @uses MywspackWsdlClass::item()
	 * @return mixed
	 */
	public function first()
	{
		return $this->item(0);
	}
	/**
	 * Method returning the last item
	 * @uses MywspackWsdlClass::item()
	 * @uses MywspackWsdlClass::length()
	 * @return mixed
	 */
	public function last()
	{
		return $this->item($this->length() - 1);
	}
	/**
	 * Method testing index in item
	 * @uses MywspackWsdlClass::getInternArrayToIterateIsArray()
	 * @uses MywspackWsdlClass::getInternArrayToIterate()
	 * @param int
	 * @return bool true|false
	 */
	public function offsetExists($_offset)
	{
		return ($this->getInternArrayToIterateIsArray() && array_key_exists($_offset,$this->getInternArrayToIterate()));
	}
	/**
	 * Method returning the item at "index" value
	 * @uses MywspackWsdlClass::offsetExists()
	 * @param int
	 * @return mixed
	 */
	public function offsetGet($_offset)
	{
		return $this->offsetExists($_offset)?$this->internArrayToIterate[$_offset]:null;
	}
	/**
	 * Method useless but necessarly overriden, can't set
	 * @param mixed $_offset
	 * @param mixed $_value
	 * @return null
	 */
	public function offsetSet($_offset,$_value)
	{
		return null;
	}
	/**
	 * Method useless but necessarly overriden, can't set
	 * @param mixed $_offset
	 * @return null
	 */
	public function offsetUnset($_offset)
	{
		return null;
	}
	/**
	 * Method returnint current result from Soap call
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->result;
	}
	/**
	 * Method setting current result from Soap call
	 * @param mixed $_result
	 * @return mixed
	 */
	protected function setResult($_result)
	{
		return ($this->result = $_result);
	}
	/**
	 * Method returning last errors occured during the calls
	 * @return array
	 */
	public function getLastError()
	{
		return $this->lastError;
	}
	/**
	 * Method setting last errors occured during the calls
	 * @param array $_lastError
	 * @return array
	 */
	private function setLastError($_lastError)
	{
		return ($this->lastError = $_lastError);
	}
	/**
	 * Method saving the last error returned by the SoapClient
	 * @param string $_methoName the method called when the error occurred
	 * @param SoapFault $_soapFault l'objet de l'erreur
	 * @return bool true|false
	 */
	protected function saveLastError($_methoName,SoapFault $_soapFault)
	{
		return ($this->lastError[$_methoName] = $_soapFault);
	}
	/**
	 * Method getting the last error for a certain method
	 * @param string method name to get error from
	 * @return SoapFault|null
	 */
	public function getLastErrorForMethod($_methoName)
	{
		return (is_array($this->lastError) && array_key_exists($_methoName,$this->lastError))?$this->lastError[$_methoName]:null;
	}
	/**
	 * Method returning intern array to iterate trough
	 * @return array
	 * @return void
	 */
	public function getInternArrayToIterate()
	{
		return $this->internArrayToIterate;
	}
	/**
	 * Method setting intern array to iterate trough
	 * @param array $_internArrayToIterate
	 * @return array
	 */
	public function setInternArrayToIterate($_internArrayToIterate)
	{
		return ($this->internArrayToIterate = $_internArrayToIterate);
	}
	/**
	 * Method returnint intern array index when iterating trough
	 * @return int
	 */
	public function getInternArrayToIterateOffset()
	{
		return $this->internArrayToIterateOffset;
	}
	/**
	 * Method initiating internArrayToIterate
	 * @uses MywspackWsdlClass::setInternArrayToIterate()
	 * @uses MywspackWsdlClass::setInternArrayToIterateOffset()
	 * @uses MywspackWsdlClass::setInternArrayToIterateIsArray()
	 * @uses MywspackWsdlClass::getAttributeName()
	 * @uses MywspackWsdlClass::initInternArrayToIterate()
	 * @uses MywspackWsdlClass::__toString()
	 * @param array $_array
	 * @param bool $_interCall
	 */
	public function initInternArrayToIterate(array $_array = array(),$_interCall = false)
	{
		if(strpos($this->__toString(),'ArrayOf') !== false)
		{
			if(count($_array))
			{
				$this->setInternArrayToIterate($_array);
				$this->setInternArrayToIterateOffset(0);
				$this->setInternArrayToIterateIsArray(true);
			}
			elseif(!$_interCall && $this->getAttributeName() != '' && property_exists($this->__toString(),$this->getAttributeName()))
				$this->initInternArrayToIterate($this->_get($this->getAttributeName()),true);
		}
	}
	/**
	 * Method setting intern array offset when iterating trough
	 * @param int $_internArrayToIterateOffset
	 * @return int
	 */
	public function setInternArrayToIterateOffset($_internArrayToIterateOffset)
	{
		return ($this->internArrayToIterateOffset = $_internArrayToIterateOffset);
	}
	/**
	 * Method returning true if intern array is an actual array
	 * @return bool true|false
	 */
	public function getInternArrayToIterateIsArray()
	{
		return $this->internArrayToIterateIsArray;
	}
	/**
	 * Method setting if intern array is an actual array
	 * @param bool $_internArrayToIterateIsArray
	 * @return bool true|false
	 */
	public function setInternArrayToIterateIsArray($_internArrayToIterateIsArray = false)
	{
		return ($this->internArrayToIterateIsArray = $_internArrayToIterateIsArray);
	}
	/**
	 * Generic method setting value
	 * @param string $_name property name to set
	 * @param mixed $_value property value to use
	 * @return bool
	 */
	public function _set($_name,$_value)
	{
		$setMethod = 'set' . ucfirst($_name);
		if(method_exists($this,$setMethod))
		{
			$this->$setMethod($_value);
			return true;
		}
		else
			return false;
	}
	/**
	 * Generic method getting value
	 * @param string $_name property name to get
	 * @return mixed
	 */
	public function _get($_name)
	{
		$getMethod = 'get' . ucfirst($_name);
		if(method_exists($this,$getMethod))
			return $this->$getMethod();
		else
			return false;
	}
	/**
	 * Method returning alone attribute name when class is ArrayOf type
	 * @return string
	 */
	public function getAttributeName()
	{
		return '';
	}
	/**
	 * Generic method telling if current value is valid according to the attribute setted with the current value
	 * @param mixed $_value the value to test
	 * @return bool true|false
	 */
	public static function valueIsValid($_value)
	{
		return true;
	}
	/**
	 * Method returning actual class name
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
}
?>