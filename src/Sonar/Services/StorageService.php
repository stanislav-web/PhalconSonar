<?php
namespace Sonar\Services;

use Sonar\Mappers\Db\Mongo\VisitorMapper;
use Sonar\Exceptions\StorageServiceException;
use Sonar\Exceptions\MongoMapperException;

/**
 * Class StorageService. Database service
 *
 * @package Sonar\Services
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Services/StorageService.php
 */
class StorageService {

    /**
     * User visitor handler
     *
     * @var \Sonar\Mappers\Db\Mongo\VisitorMapper $visitorMapper
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
     * @throws \Sonar\Exceptions\StorageServiceException
     * @return \MongoId
     */
    public function add(array $data) {

        try {
            // add user data
            $lastInsertId = $this->visitorMapper->add($data);

            return $lastInsertId;
        }
        catch(MongoMapperException $e) {
            throw new StorageServiceException($e->getMessage());
        }
    }
}