<?php
namespace Octopussy\Aware;

/**
 * AbstractQueueMapper class. Abstract mapper for queue clients
 *
 * @package Octopussy
 * @subpackage Octopussy\Aware
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Aware/AbstractQueueMapper.php
 */
abstract class AbstractQueueMapper {

    /**
     * Put data to task
     *
     * @param array $data
     * @param array $options optional task config
     * @throws \Octopussy\Exceptions\BeanstalkMapperException
     * @return \MongoId
     */
    abstract public function put(array $data, array $options = []);
}