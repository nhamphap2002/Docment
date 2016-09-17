<?php

/**
 * @package     Fgc.Modules
 * @subpackage  fgcautoshare - Auto share products to social channels (Twitter, Facebook, LinkedIn, etc).
 *
 * @author      Fgc techlution. <hoangbien264@gmail.com>
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 * @link        http://fgc.vn
 */

/**
 * ShorturlHelper
 *
 * @package     Fgc.Modules
 * @subpackage  fgcautoshare
 * @since       1.0
 */
class ShorturlHelper {

    // Seconds
    const RESEND_DELAY = 1;

    // General params for message and posting
    protected $resend_attempts = 2;
    protected $shorturl_service = 'Tinyurlcom';
    // Bit.ly and yourls account data
//	protected $bit_username = '';
//
//	protected $bit_key = '';
//
//	protected $yourls_host = '';
//
//	protected $yourls_token = '';

    private static $_instance = null;

    /**
     * ShorturlHelper. No public access (singleton pattern).
     *
     */
    protected function __construct() {

        include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'urlshortservices' . DIRECTORY_SEPARATOR . 'autoshareshortservice.php');
        include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'urlshortservices' . DIRECTORY_SEPARATOR . 'autoshareurlshortservicefactory.php');
        // General params for message and posting
        $this->resend_attempts = 2; //EParameter::getComponentParam(CAUTOTWEETNG, 'resend_attempts', 2);
        $this->shorturl_service = 'Tinyurlcom'; //EParameter::getComponentParam(CAUTOTWEETNG, 'shorturl_service', 'Tinyurlcom');
    }

    /**
     * getInstance
     *
     * @return	Instance
     *
     * @since	1.5
     */
    public static function &getInstance() {
        if (!self::$_instance) {
            self::$_instance = new ShorturlHelper;
        }

        return self::$_instance;
    }

    /**
     * getShortUrl.
     *
     * @param   string  $url  Param
     *
     * @return	string
     *
     * @since	1.5
     */
    public function getShortUrl($url) {
        $shorturl_service = $this->shorturl_service;

        if (('0' != $shorturl_service) && !empty($url)) {
            // Get short url service
            $data = array(
                'type' => $shorturl_service,
                    //'bit_username' => $this->bit_username,
                    //'bit_key' => $this->bit_key,
                    //'google_api_key' => $this->google_api_key,
                    //'yourls_host' => $this->yourls_host,
                    //'yourls_token' => $this->yourls_token
            );
            $service = AutoShareURLShortserviceFactory::getInstance($data);

            // Get short url
            $attempt = 0;

            do {
                $resend = false;
                $attempt++;

                $short_url = $service->getShortUrl($url);

                if (($attempt < $this->resend_attempts) && empty($short_url)) {
                    $resend = true;
                    //$this->logger->log(JLog::WARNING, 'getShortUrl: Short url service ' . $shorturl_service . ' ' . $service->getErrorMessage() . ' - try again in ' . self::RESEND_DELAY . ' seconds');
                    file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'log.txt', 'Warning: getShortUrl: Short url service ' . $shorturl_service . ' ' . $service->getErrorMessage() . ' - try again in ' . self::RESEND_DELAY . ' seconds' . "\n", FILE_APPEND);
                    sleep(self::RESEND_DELAY);
                }
            } while ($resend);

            if (!empty($short_url)) {
                $url = $short_url;
                file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'log.txt', 'getShortUrl: url shortened, short url = ' . $short_url . "\n", FILE_APPEND);
                //$this->logger->log(JLog::INFO, 'getShortUrl: url shortened, short url = ' . $short_url);
            } else {
                file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'log.txt', 'Warning: getShortUrl: Short url service ' . $shorturl_service . ' failed. Normal url used.' . "\n", FILE_APPEND);
                //$this->logger->log(JLog::WARNING, 'getShortUrl: Short url service ' . $shorturl_service . ' failed. Normal url used.');
            }
        }

        return $url;
    }

}
