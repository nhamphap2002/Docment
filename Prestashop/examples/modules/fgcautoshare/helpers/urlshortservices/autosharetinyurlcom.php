<?php

/**
 * @package     Fgc.Modules
 * @subpackage fgcautoshare - auto post product info to social channels (Twitter, Facebook, LinkedIn, etc).
 *
 * @author      FgcTechlution <hoangbien264@gmail.com>
 * @copyright   Copyright (C) 2007 - 2014 Prieco, S.A. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 * @link        http://fgc.vn
 */
include_once 'autoshareshortservice.php';

/**
 * AutoShareTinyurlcomService
 *
 * @package      Fgc.Modules
 * @subpackage  fgcautoshare
 * @since       1.0
 */
class AutoShareTinyurlcomService extends AutoShareShortservice
{
	/**
	 * Construct
	 *
	 * @param   array  $data  Param
	 */
	public function __construct($data)
	{
		parent::__construct($data);
	}

	/**
	 * getShortURL
	 *
	 * @param   string  $long_url  Param.
	 *
	 * @return	string
	 */
	public function getShortUrl($long_url)
	{
		return $this->callSimpleService('http://tinyurl.com/api-create.php?url=', $long_url);
	}
}
