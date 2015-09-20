<?php
namespace Octopussy\Mappers\Queue;

use Octopussy\Aware\AbstractQueueMapper;
use Octopussy\Exceptions\BeanstalkMapperException;
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
     * @throws \Octopussy\Exceptions\BeanstalkMapperException
     */
    public function __construct(array $config = null) {

        if($this->connect === null) {
            try {
                $this->connect = new Beanstalk($config);
                $this->connect->connect();
            }
            catch(\Exception $e) {
                throw new BeanstalkMapperException($e->getMessage());
            }
        }
    }

    /**
     * Put message
     *
     * @param string $message
     * @param array $options optional task config
     * @return null
     */
    public function put($message, array $options = []) {

        $this->connect->put($message, $options);

        return null;
    }

    /**
     * Read message
     *
     * @param array $credentials
     * @param callable $callback
     * @throws \Octopussy\Exceptions\BeanstalkMapperException
     */
    public function read(array $credentials)
    {
        try {

            while (($job = $this->connect->peekReady()) !== false) {

                $message = unserialize($job->getBody());

                if($message['hash'] === $credentials['hash']) {
                    // hash found! Remove job from queue and return message
                    $job->delete();
                    unset($message['hash']);
                    return $message;
                }
            }
        }
        catch(\Exception $e) {
            throw new BeanstalkMapperException($e->getMessage());
        }
    }
}