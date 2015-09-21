<?php
namespace Octopussy\Aware;

/**
 * Interface ModelInterface. Abstract model interface
 *
 * @package Octopussy\Aware
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Aware/ModelInterface.php
 */
interface ModelInterface {

    /**
     * Receiving incoming data
     *
     * @param mixed $data
     */
    public function __construct($data);

    /**
     * Get properties as array view
     *
     * @return array
     */
    public function toArray();
}