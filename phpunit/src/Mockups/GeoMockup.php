<?php
namespace Sonar\Mockups;

use Ivory\HttpAdapter\CurlHttpAdapter;
use Geocoder\ProviderAggregator;
use Geocoder\Provider\Chain;
use Geocoder\Provider\FreeGeoIp;
use Geocoder\Provider\HostIp;

/**
 * Class GeoMockup
 *
 * @package Sonar\Mockups
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Mockups/GeoMockup.php
 */
class GeoMockup {

    const IP_ADDRESS = '194.63.141.110';

    /**
     * Geocoder package
     *
     * @var \Geocoder\Geocoder $geocoder
     */
    private $geocoder;

    /**
     * Implement geocoder providers
     */
    public function __construct() {

        if($this->geocoder === null) {
            $this->geocoder = new ProviderAggregator();
            $adapter  = new CurlHttpAdapter();

            $chain = new Chain([
                new FreeGeoIp($adapter),
                new HostIp($adapter),
            ]);

            $this->geocoder->registerProvider($chain);
        }
    }

    /**
     * Get geo mockup data
     *
     * @return \Geocoder\Model\AddressCollection
     */
    public function getMockData() {

        return $this->geocoder->geocode(self::IP_ADDRESS);
    }

    /**
     * Get returned result keys
     *
     * @return array
     */
    public function getReturnedResultKeys() {

        return [
            'coordinates',
            'address',
            'locality',
            'countryCode',
            'postalCode'
        ];
    }

}