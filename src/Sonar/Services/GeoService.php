<?php
namespace Sonar\Services;

use Ivory\HttpAdapter\CurlHttpAdapter;
use Geocoder\ProviderAggregator;
use Geocoder\Provider\Chain;
use Geocoder\Provider\FreeGeoIp;
use Geocoder\Provider\HostIp;
use Sonar\Exceptions\GeoServiceException;
use Sonar\Models\Geo;

/**
 * Class GeoService. Geo location service
 *
 * @package Sonar\Services
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Services/GeoService.php
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
     * @throws \Sonar\Exceptions\GeoServiceException
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