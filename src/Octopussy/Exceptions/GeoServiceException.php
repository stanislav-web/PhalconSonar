<?php
namespace Octopussy\Exceptions;

use Octopussy\Aware\AbstractBaseException;

/**
 * Class GeoServiceException. Geo service exception class
 * Low-level catching errors class
 *
 * @package Octopussy\Exceptions
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Exceptions/GeoServiceException.php
 */
class GeoServiceException extends AbstractBaseException {

    /**
     * Constructor
     *
     * @param string $message
     * @param string $code status code
     */
    public function __construct($message) {
        parent::__construct($message, self::class);
    }
}