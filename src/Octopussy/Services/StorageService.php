<?php
namespace Octopussy\Services;

use Octopussy\Mappers\Mongo\VisitorMapper;
use Octopussy\Exceptions\StorageException;
use Octopussy\Exceptions\VisitorMapperException;

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
     * @var \Octopussy\Mappers\VisitorMapper $mapper
     */
    private $mapper;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->mapper = new VisitorMapper($config);
    }

    /**
     * Add record to collection
     *
     * @param array $data
     */
    public function add(array $data) {

        try {
            $this->mapper->add($data);
        }
        catch(VisitorMapperException $e) {
            throw new StorageException($e->getMessage());
        }
    }
}