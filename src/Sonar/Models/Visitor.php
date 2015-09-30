<?php
namespace Sonar\Models;

use Mobile_Detect;
use Sonar\Aware\ModelInterface;

/**
 * Class Visitor. Visitor's collection model
 *
 * @package Sonar\Models
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Models/Visitor.php
 */
class Visitor implements ModelInterface {

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
     * User preferred language (by browser)
     *
     * @var string $language
     */
    private $language;

    /**
     * User defined location
     *
     * @var array $location
     */
    private $location = [];

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
     * Is client from pc
     *
     * @var int $isPc
     */
    private $pc   =   0;

    /**
     * Current page
     *
     * @var string $page
     */
    private $page   =   '';

    /**
     * Start request time
     *
     * @var int $open
     */
    private $open;

    /**
     * End request time
     *
     * @var int $close
     */
    private $close;

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
    public function __construct($data) {

        // init detector
        $this->detector = new Mobile_Detect();

        // validate client data
        $this->setPage($data['page']);
        $this->setIp($data['ip']);
        $this->setUa($data['ua']);
        $this->setLocation($data['location']);
        $this->setOpenTime($data['open']);
        $this->setCloseTime($data['close']);
        $this->setLanguage($data['language']);
        $this->deviceDetect();

    }

    /**
     * Set current page
     *
     * @param string $page
     * @return Visitor
     */
    public function setPage($page)
    {
        $this->page = trim(strip_tags($page));

        return $this;
    }

    /**
     * Set ip to long int
     *
     * @param string $ip
     * @return Visitor
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);

        return $this;
    }

    /**
     * Set timestamp point open
     *
     * @param int $open
     * @return Visitor
     */
    public function setOpenTime($open)
    {
        $this->open = (int)$open;

        return $this;
    }

    /**
     * Set timestamp point close
     *
     * @param int $close
     * @return Visitor
     */
    public function setCloseTime($close)
    {
        $this->close = (int)$close;

        return $this;
    }

    /**
     * Set user preferred language
     *
     * @param string $language
     * @return Visitor
     */
    private function setLanguage($language)
    {
        $this->language = trim($language);

        return $this;
    }

    /**
     * Set user agent
     *
     * @param string $ua
     * @return Visitor
     */
    public function setUa($ua)
    {
        $this->ua = $this->detector->setUserAgent($ua);

        // set browser & platform
        $this->setBrowser();

        return $this;
    }

    /**
     * Set user browser
     *
     * @return Visitor
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
     * @param string $platform
     * @return Visitor
     */
    private function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Set location
     *
     * @param array|null $location
     * @return Visitor
     */
    private function setLocation(array $location = null)
    {
        $this->location = ($location != null) ? 'Undefined' : $location;

        return $this;
    }

    /**
     * Detect client device
     *
     * @return Visitor
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
     * Get properties as array view
     *
     * @return array
     */
    public function toArray() {

        $properties = get_object_vars($this);

        foreach($properties as $var => &$value) {
            if(gettype($value)  === 'object') {
                unset($properties[$var]);
            }
        }

        return $properties;
    }

}