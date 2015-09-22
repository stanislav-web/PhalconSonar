<?php
namespace Sonar\Aware;

/**
 * Class AbstractBaseException. Base exception class
 *
 * @package Sonar\Aware
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Aware/AbstractBaseException.php
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
     * @param string $exception child exception
     */
    public function __construct($message, $exception) {

        $message = $exception.self::DELIMITER.$message; // use as late state binding
        parent::__construct($message, self::CODE);
    }
}