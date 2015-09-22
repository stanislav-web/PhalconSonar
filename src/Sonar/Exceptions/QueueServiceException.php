<?php
namespace Sonar\Exceptions;

/**
 * Class QueueServiceException. Queue service exception class
 *
 * @package Sonar\Exceptions
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Exceptions/QueueServiceException.php
 */
class QueueServiceException extends \RuntimeException {

    /**
     * @const CODE exception code
     */
    const CODE = 500;

    /**
     * Constructor
     *
     * @param string $message
     * @param integer $code status code
     */
    public function __construct($message, $code = self::CODE) {
        parent::__construct($message, $code);
    }
}