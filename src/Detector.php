<?php
/**
 * @author    : JIHAD SINNAOUR
 * @package   : VanillePlugin
 * @version   : 0.0.1
 * @copyright : (c) 2018 - 2020 JIHAD SINNAOUR <mail@jihadsinnaour.com>
 * @link      : https://jakiboy.github.io/VanillePlugin/
 * @license   : MIT
 */

namespace Cloaker;

class Detector
{
	/**
	 * @access public
	 *
	 * boolean $isGoogleBot
	 */
	public $isGoogleBot = false;

	/**
	 * @access private
	 *
	 * string $reverseIp
	 * string $userAgent
	 */
	private $reverseIp;
	private $userAgent;

	/**
	 * @param string $useragent
	 * @param string $ip
	 * @return object Cloaking
	 */
	public function __construct($useragent = null, $ip = null)
	{
		$this->setUserAgent($useragent);
		$this->reverseIp($ip);
		$this->checkCloacking();
		return $this;
	}

	/**
	 * @param string $ip
	 * @return void
	 */
	private function reverseIp($ip)
	{
		if ($ip) {
			$this->reverseIp = gethostbyaddr($ip);
		} else {
			$this->reverseIp = isset($_SERVER['REMOTE_ADDR'])
			? gethostbyaddr($_SERVER['REMOTE_ADDR']) : false;
		}
	}

	/**
	 * @param string $useragent
	 * @return void
	 */
	public function setUserAgent($useragent)
	{
		if ($useragent){
			$this->userAgent = $useragent;
		} else {
			$this->userAgent = isset($_SERVER['HTTP_USER_AGENT'])
			? $_SERVER['HTTP_USER_AGENT'] : false;
		}
	}

    /**
	 * @param void
	 * @return void
     */
    protected function checkCloacking()
    {
    	if ( $this->isGoogleDNS() || $this->isGoogleUA() ) {
    		$this->isGoogleBot = true;
    	}
    }

    /**
	 * @param void
	 * @return boolean
	 *
	 * PREG_OFFSET_CAPTURE : 256
     */
    protected function isGoogleDNS()
    {
        preg_match('/google/', $this->reverseIp, $dns, 256);
        if (count($dns) > 0) {
           return true;
        }
        return false;
    }

    /**
	 * @param void
	 * @return boolean
	 *
	 * PREG_OFFSET_CAPTURE : 256
     */
    protected function isGoogleUA()
    {
        preg_match('/Googlebot/', $this->userAgent, $useragent, 256);
        if (count($useragent) > 0) {
           return true;
        }
        return false;
    }
}
