<?php
namespace Octopussy\Mappers\Queue;

use Octopussy\Aware\AbstractQueueMapper;
use Phalcon\Queue\Beanstalk;

/**
 * QueueService class. Queue service
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/Queue/BeanstalkMapper.php
 */
class BeanstalkMapper extends AbstractQueueMapper {

    /**
     * @var \Phalcon\Queue\Beanstalk $connect
     */
    private $connect = null;

    /**
     * Implement configurations
     *
     * @param array $config
     */
    public function __construct(array $config = null) {

        if($this->connect === null) {
            $this->connect = new Beanstalk($config);
        }
    }

    /**
     * Put data to task
     *
     * @param array $data
     * @param array $options optional task config
     * @throws \Octopussy\Exceptions\BeanstalkMapperException
     * @return \MongoId
     */
    public function put(array $data, array $options = []) {
        // TODO: Implement put() method.
    }
}