<?php
namespace Sonar\Aware;

/**
 * Interface ModelInterface. Abstract model interface
 *
 * @package Sonar\Aware
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Aware/ModelInterface.php
 */
interface ModelInterface {

    /**
     * Receiving incoming data
     *
     * @param mixed $data
     * @return void
     */
    public function __construct($data);

    /**
     * Get properties as array view
     *
     * @return array
     */
    public function toArray();
}