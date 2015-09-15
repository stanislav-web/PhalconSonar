<?php
namespace Octopussy\Mappers;
use Octopussy\Exceptions\StorageException;

/**
 * MongoMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/MongoMapper.php
 */
class MongoMapper {

    /**
     * MongoDB client connection
     *
     * @var \MongoClient $connection
     */
    public $connection;

    /**
     * Implement configurations for MongoDB connection
     *
     * @param \Phalcon\Config $config
     * @throws \Octopussy\Exceptions\StorageException
     */
    public function __construct(\Phalcon\Config $config) {

        $uri = "mongodb://".$config['user'].":".$config['password']."@".$config['host'].":".$config['port']."/".$config['dbname'];

        try {

            $this->connection = new \MongoClient($uri);
            $this->connection->selectDB($config['dbname']);
        }
        catch(\MongoConnectionException $e) {
            throw new StorageException('Could not connect to mongoDb server');
        }
    }
}