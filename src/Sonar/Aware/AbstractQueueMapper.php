<?php
namespace Sonar\Aware;

/**
 * Class AbstractQueueMapper. Abstract mapper for queue clients
 *
 * @package Sonar\Aware
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Aware/AbstractQueueMapper.php
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
     */
    abstract public function read(array $credentials);
}