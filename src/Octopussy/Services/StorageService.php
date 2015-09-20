<?php

namespace Octopussy\Services;

use Octopussy\Mappers\Db\Mongo\VisitorMapper;
use Octopussy\Exceptions\StorageException;
use Octopussy\Exceptions\VisitorMapperException;

/**
 * Class StorageService. Database service
 *
 * @package Octopussy\Services
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/StorageService.php
 */
class StorageService {

    /**
     * User visitor handler
     *
     * @var \Octopussy\Mappers\Db\Mongo\VisitorMapper $visitorMapper
     */
    private $visitorMapper;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->visitorMapper = new VisitorMapper($config);
    }

    /**
     * Add record to collection
     *
     * @param array $data
     * @return \MongoId
     */
    public function add(array $data) {

        try {
            // add user data
            $lastInsertId = $this->visitorMapper->add($data);

            return $lastInsertId;
        }
        catch(VisitorMapperException $e) {
            throw new StorageException($e->getMessage());
        }
    }
}