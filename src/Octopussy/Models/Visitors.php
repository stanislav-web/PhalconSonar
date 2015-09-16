<?php

namespace Octopussy\Models;

/**
 * Visitors class. Visitor's ODM
 *
 * @package Octopussy
 * @subpackage Octopussy\Models
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/Visitors.php
 */
class Visitors {

    /**
     * Collection name
     *
     * @const COLLECTION
     */
    const COLLECTION = 'visitors';

    /**
     * IP Address
     *
     * @var int $ip
     */
    public $ip;

    /**
     * User Agent
     *
     * @var string $ua
     */
    public $ua;

    /**
     * User browser
     *
     * @var string $browser
     */
    public $browser;

    /**
     * Request time
     *
     * @var int $time
     */
    public $time;


    /**
     * Set ip to long int
     *
     * @param string $ip
     * @return Visitors
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    /**
     * Get ip address
     *
     * @return string
     */
    public function getIp()
    {
        return long2ip($this->ip);
    }


    /**
     * Get user agent
     *
     * @return string
     */
    public function getUa()
    {
        return $this->ua;
    }

    /**
     * Set user agent
     *
     * @param string $ua
     * @return Visitors
     */
    public function setUa($ua)
    {
        $this->ua = $ua;

        return $this;
    }

    /**
     * Set user browser
     *
     * @param string $ua
     * @return Visitors
     */
    public function setBrowser($ua)
    {
        $this->browser = $ua;

        return $this;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set timestamp point
     *
     * @param int $time
     * @return Visitors
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

}