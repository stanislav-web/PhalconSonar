<?php
namespace Octopussy\Models;

use Mobile_Detect;

/**
 * Visitors class. Visitor's collection model
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
    private $ip;

    /**
     * User Agent
     *
     * @var string $ua
     */
    private $ua;

    /**
     * User browser
     *
     * @var string $browser
     */
    private $browser;

    /**
     * User OS type
     *
     * @var string $platform
     */
    private $platform;

    /**
     * Is client from mobile
     *
     * @var int $mobile
     */
    private $mobile = 0;

    /**
     * Is client from tablet pc
     *
     * @var int $isTablet
     */
    private $tablet = 0;

    /**
     * is client from pc
     *
     * @var int $isPc
     */
    private $pc   =   0;

    /**
     * Request time
     *
     * @var int $time
     */
    private $time;

    /**
     * Detect mobile library instance
     *
     * @var Mobile_Detect $detector
     */
    private $detector;


    /**
     * Initialize model & validate client data
     *
     * @param array $data
     */
    public function __construct(array $data) {

        // init detector
        $this->detector = new Mobile_Detect(null, $data['ua']);

        // validate client data
        $this->setIp($data['ip'])->setTime($data['time'])->setUa()->deviceDetect();
    }

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
     * @return Visitors
     */
    public function setUa()
    {
        $this->ua = $this->detector->getUserAgent();

        // set browser & platform
        $this->setBrowser();

        return $this;
    }

    /**
     * Detect client device
     *
     * @return Visitors
     */
    private function deviceDetect()
    {
        $this->mobile   = (int)$this->detector->isMobile();
        $this->tablet   = (int)$this->detector->isTablet();

        if ($this->mobile === 0 && $this->tablet === 0) {
            $this->pc = 1;
        }

        return $this;
    }

    /**
     * Set user browser
     *
     * @return Visitors
     */
    private function setBrowser()
    {
        $client = parse_user_agent($this->detector->getUserAgent());
        $this->browser = $client['browser'];
        $this->setPlatform($client['platform']);

        return $this;
    }

    /**
     * Set user OS platform
     *
     * @return Visitors
     */
    private function setPlatform($platform)
    {
        $this->platform = $platform;

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

    /**
     * Get properties as array view
     *
     * @return array
     */
    public function toArray() {

        foreach($properties = get_object_vars($this) as $var => &$value) {
            if(gettype($value)  === 'object') {
                unset($properties[$var]);
            }
        }

        return $properties;
    }

}