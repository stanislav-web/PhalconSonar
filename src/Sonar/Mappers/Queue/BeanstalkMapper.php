<?php
namespace Sonar\Mappers\Queue;

use Sonar\Aware\AbstractQueueMapper;
use Sonar\Exceptions\BeanstalkMapperException;
use Phalcon\Queue\Beanstalk;

/**
 * Class BeanstalkMapper. Queue service
 *
 * @package Sonar\Mappers\Queue
 * @subpackage Sonar\Mappers
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Mappers/Queue/BeanstalkMapper.php
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
     * @throws \Sonar\Exceptions\BeanstalkMapperException
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
     * @throws \Sonar\Exceptions\BeanstalkMapperException
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