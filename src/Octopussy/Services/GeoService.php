<?php
namespace Octopussy\Services;

use Ivory\HttpAdapter\CurlHttpAdapter;
use Geocoder\ProviderAggregator;
use Geocoder\Provider\Chain;
use Geocoder\Provider\FreeGeoIp;
use Geocoder\Provider\HostIp;
use Octopussy\Exceptions\GeoServiceException;
use Octopussy\Models\Geo;

/**
 * Class GeoService. Geo location service
 *
 * @package Octopussy\Services
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/GeoService.php
 */
class GeoService {

    /**
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
     * Get address from requested param
     *
     * @param string $param
     * @throws \Octopussy\Exceptions\GeoServiceException
     * @return \Geocoder\Model\AddressCollection
     */
    public function location($param) {

        try {

            $result = $this->geocoder->geocode($param);

            // parse  data from geo locator
            return (new Geo($result))->toArray();

        } catch (\Exception $e) {
            throw new GeoServiceException($e->getMessage());
        }
    }
}