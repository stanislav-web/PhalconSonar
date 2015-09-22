<?php
namespace Sonar\Exceptions;

use Sonar\Aware\AbstractBaseException;

/**
 * Class SocketServiceException. Socket service exception class
 * Low-level catching errors class

 * @package Sonar\Exceptions
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Exceptions/SocketServiceException.php
 */
class SocketServiceException extends AbstractBaseException {

    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message, self::class);
    }
}