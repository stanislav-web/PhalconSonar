<?php
namespace Octopussy\Exceptions;

/**
 * VisitorMapperException class. VisitorMapper exception class
 *
 * @package Octopussy
 * @subpackage Octopussy\Exceptions
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Exceptions/VisitorMapperException.php
 */
class VisitorMapperException extends \RuntimeException {

    /**
     * @const CODE exception code
     */
    const CODE = 500;

    /**
     * Constructor
     *
     * @param string $message
     * @param string $code status code
     */
    public function __construct($message, $code = self::CODE) {
        parent::__construct($message, $code);
    }
}