<?php

namespace Octopussy\Services;

use Octopussy\Mappers\Db\Mongo\SessionMapper;
use Octopussy\Mappers\Db\Mongo\VisitorMapper;
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
     * User visitor handler
     *
     * @var \Octopussy\Mappers\Db\Mongo\VisitorMapper $visitorMapper
     */
    private $visitorMapper;

    /**
     * Session user handler
     *
     * @var \Octopussy\Mappers\Db\Mongo\SessionMapper $sessionMapper
     */
    private $sessionMapper;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     */
    public function __construct(\Phalcon\Config $config) {

        $this->visitorMapper = new VisitorMapper($config);
        $this->sessionMapper = new SessionMapper($config);
    }

    /**
     * Add record to collection
     *
     * @param array $data
     */
    public function add(array $data) {

        try {
            // add user data
            $lastInsertId = $this->visitorMapper->add($data);

            // save id to session
            $this->sessionMapper->add([
                'id' => $lastInsertId->{'$id'},
                'hash' => md5(serialize($data))
            ]);
        }
        catch(VisitorMapperException $e) {
            throw new StorageException($e->getMessage());
        }
    }
}