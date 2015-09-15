<?php
namespace Octopussy\Services;

use Octopussy\Mappers\MongoMapper;

/**
 * StorageService class. Database service
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/StorageService.php
 */
class StorageService {

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

        $this->mapper = new MongoMapper($config);
    }

    public function save(array $data) {

        print_r($data);
    }
}