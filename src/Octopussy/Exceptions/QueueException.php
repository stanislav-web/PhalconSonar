<?php
namespace Octopussy\Exceptions;

/**
 * QueueException class. Queue exception class
 *
 * @package Octopussy
 * @subpackage Octopussy\Exceptions
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Exceptions/QueueException.php
 */
class QueueException extends \DomainException {

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