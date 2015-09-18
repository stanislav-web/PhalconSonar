<?php

namespace Octopussy\Services;

use Octopussy\Exceptions\QueueException;
use Octopussy\Mappers\Queue\BeanstalkMapper;
use Octopussy\Exceptions\BeanstalkMapperException;

/**
 * QueueService class. Queue service
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/QueueService.php
 */
class QueueService {

    /**
     * Beanstalk server's mapper
     *
     * @var \Octopussy\Mappers\Queue\BeanstalkMapper $beanstalkMapper
     */
    private $beanstalkMapper = null;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     * @throws \Octopussy\Exceptions\QueueException
     */
    public function __construct(\Phalcon\Config $config) {

        if($this->beanstalkMapper === null) {

            try {
                $this->beanstalkMapper = new BeanstalkMapper($config->toArray());
            }
            catch(BeanstalkMapperException $e) {
                throw new QueueException($e->getMessage());
            }
        }
    }
}