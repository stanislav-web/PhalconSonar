<?php
namespace Sonar\Models;

use Sonar\Aware\ModelInterface;
use Geocoder\Formatter\StringFormatter;

/**
 * Class Geo. Geo resolving model
 *
 * @package Sonar\Models
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Models/Geo.php
 */
class Geo implements ModelInterface {

    /**
     * Address formatter
     *
     * @var \Geocoder\Formatter\StringFormatter $formatter
     */
    private $formatter;

    /**
     * Coordinates
     *
     * @var array $coordinates
     */
    private $coordinates = [];

    /**
     * Address
     *
     * @var string $address
     */
    private $address = '';

    /**
     * Locality (city)
     *
     * @var string $locality
     */
    private $locality = '';

    /**
     * Country
     *
     * @var string $country
     */
    private $country = '';

    /**
     * Country code
     *
     * @var string $countryCode
     */
    private $countryCode = '';

    /**
     * Postal code
     *
     * @var string $postalCode
     */
    private $postalCode = '';

    /**
     * Initialize model & validate client data
     *
     * @param array $data
     */
    public function __construct($data) {

        // setup incoming data
        $this->setCoordinates($data->first());
        $this->setAddress($data->first());
        $this->setLocality($data->first());
        $this->setCountry($data->first());
        $this->setCountryCode($data->first());
        $this->setPostalCode($data->first());
    }

    /**
     * Set coordinates
     *
     * @param \Geocoder\Model\Address $coordinates
     * @return Geo
     */
    private function setCoordinates(\Geocoder\Model\Address $coordinates) {

        $this->coordinates = [
            'latitude'      => $coordinates->getLatitude(),
            'longtitude'    => $coordinates->getLongitude()
        ];

        return $this;
    }

    /**
     * Set address
     *
     * @param \Geocoder\Model\Address $address
     * @return Geo
     */
    private function setAddress($address) {

        if(!$this->formatter) {
            $this->formatter = new StringFormatter();
        }

        $this->address = trim($this->formatter->format($address, '%S %n %z %L %C'));

        return $this;
    }

    /**
     * Set locality
     *
     * @param \Geocoder\Model\Address $address
     * @return Geo
     */
    private function setLocality($address) {

        $this->locality = $address->getLocality();

        return $this;
    }

    /**
     * Set country
     *
     * @param \Geocoder\Model\Address $address
     * @return Geo
     */
    private function setCountry($address) {

        $this->country = $address->getCountry();

        return $this;
    }

    /**
     * Set country code
     *
     * @param \Geocoder\Model\Address $address
     * @return Geo
     */
    private function setCountryCode($address) {

        $this->countryCode = $address->getCountryCode();

        return $this;
    }

    /**
     * Set postal code
     *
     * @param \Geocoder\Model\Address $address
     * @return Geo
     */
    private function setPostalCode($address) {

        $this->postalCode = $address->getPostalCode();

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