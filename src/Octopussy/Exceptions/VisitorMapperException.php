<?php
namespace Octopussy\Exceptions;

/**
 * Class VisitorMapperException. Visitor mapper exception class
 * Low-level catching errors class
 *
 * @package Octopussy\Exceptions
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Exceptions/VisitorMapperException.php
 */
class VisitorMapperException extends BeanstalkMapperException {

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