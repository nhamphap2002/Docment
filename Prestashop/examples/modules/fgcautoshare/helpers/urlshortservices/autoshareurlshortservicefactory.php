<?php

class AutoShareURLShortserviceFactory
{
	/**
	 * AutotweetURLShortserviceFactory
	 */
	private function __construct()
	{
		// Static class
	}

	/**
	 * getInstance
	 *
	 * @param   array  $data  Param
	 *
	 * @return	object
	 */
	public static function getInstance($data)
	{
		//JLoader::register('AutotweetTinyurlcomService', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'autotweettinyurlcom.php');
                include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'autosharetinyurlcom.php');
		$classname = 'AutoShare' . $data['type'] . 'Service';

		return new $classname($data);
	}
}
