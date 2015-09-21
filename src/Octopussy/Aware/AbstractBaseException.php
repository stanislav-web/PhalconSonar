<?php
namespace Octopussy\Aware;

/**
 * Class AbstractBaseException. Base exception class
 *
 * @package Octopussy\Aware
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Aware/AbstractBaseException.php
 */
abstract class AbstractBaseException extends \RuntimeException {

    /**
     * @const CODE default
     */
    const CODE = 500;

    /**
     * @const DELIMITER default
     */
    const DELIMITER = ' : ';

    /**
     * Constructor
     *
     * @param string $message
     * @param string $code status code
     */
    public function __construct($message, $except) {

        $message = $except.self::DELIMITER.$message; // use as late state binding
        parent::__construct($message, self::CODE);
    }
}