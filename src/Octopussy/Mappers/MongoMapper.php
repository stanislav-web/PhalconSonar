<?php
namespace Octopussy\Mappers;

/**
 * MongoMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers
 * @since PHP >=5.6
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
     */
    public function __construct(\Phalcon\Config $config) {

        $uri = "mongodb://".$config['user'].":".$config['password']."@".$config['host'].":".$config['port']."/".$config['dbname'];

        $this->connection = new \MongoClient($uri);
        $this->connection->selectDB($config['dbname']);
    }
}