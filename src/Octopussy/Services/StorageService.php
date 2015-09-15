<?php
namespace Octopussy\Services;

use Octopussy\Mappers\MongoMapper;

/**
 * StorageService class. Database service
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/StorageService.php
 */
class StorageService {

    /**
     * Storage configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * @var \Octopussy\Mappers\MongoMapper $mapper
     */
    private $mapper;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     */
    public function __construct(\Phalcon\Config $config) {
        $this->config = $config;
        $this->mapper = new MongoMapper($this->config);
    }
}