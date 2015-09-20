<?php
namespace Octopussy\Aware;

/**
 * Class AbstractQueueMapper. Abstract mapper for queue clients
 *
 * @package Octopussy\Aware
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Aware/AbstractQueueMapper.php
 */
abstract class AbstractQueueMapper {

    /**
     * Put message
     *
     * @param string $data
     * @param array $options optional task config
     * @return null
     */
    abstract public function put($data, array $options = []);

    /**
     * Read message
     *
     * @param array $credentials
     * @param callable $callback
     */
    abstract public function read(array $credentials);
}