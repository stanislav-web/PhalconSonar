<?php
namespace Octopussy\Models;

use Mobile_Detect;

/**
 * Visitor class. Visitor's collection model
 *
 * @package Octopussy
 * @subpackage Octopussy\Models
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/Visitor.php
 */
class Visitor {

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
        $this->setPage($data['page'])
                    ->setIp($data['ip'])
                        ->setOpenTime($data['open'])
                            ->setLanguage($data['language'])
                                ->setUa()
                                    ->deviceDetect();
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
     * @return Visitor
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
     * Set user language
     *
     * @return Visitor
     */
    private function setLanguage($language)
    {
        $this->language = trim($language);
        return $this;
    }

    /**
     * Set user OS platform
     *
     * @return Visitor
     */
    private function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return int
     */
    public function getOpenTime()
    {
        return $this->open;
    }

    /**
     * Set current page
     *
     * @param int $page
     * @return Visitor
     */
    public function setPage($page)
    {
        $this->page = trim(strip_tags($page));

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
        $this->open = $open;

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