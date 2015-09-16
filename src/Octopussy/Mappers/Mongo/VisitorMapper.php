<?php
namespace Octopussy\Mappers\Mongo;

use Octopussy\Exceptions\StorageException;
use Octopussy\Models\Visitors;

/**
 * VisitorMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/VisitorMapper.php
 */
class VisitorMapper {

    /**
     * MongoDB client connection
     *
     * @var \MongoClient $client
     */
    public $client;

    /**
     * Database instance
     *
     * @var \MongoDB
     */
    public $db;

    /**
     * Collection instance
     *
     * @var \MongoCollection
     */
    public $collection;

    /**
     * Implement configurations for MongoDB connection
     *
     * @param \Phalcon\Config $config
     * @throws \Octopussy\Exceptions\StorageException
     */
    public function __construct(\Phalcon\Config $config) {

        $uri = "mongodb://".$config['user'].":".$config['password']."@".$config['host'].":".$config['port']."/".$config['dbname'];

        try {

            if(!$this->collection) {
                $this->client = new \MongoClient($uri);
                $this->db = $this->client->selectDB($config['dbname']);
                $this->collection = $this->db->selectCollection(Visitors::COLLECTION);
            }
        }
        catch(\MongoConnectionException $e) {
            throw new StorageException($e->getMessage());
        }
    }

    /**
     * Add records to collection
     *
     * @param array $data
     * @throws \Octopussy\Exceptions\StorageException
     */
    public function add(array $data) {

        try {
            $this->collection->insert((new Visitors($data))->toArray(), ['safe' => true]);
        }
        catch(\MongoException $e) {
            throw new VisitorMapperException($e->getMessage());
        }
    }
}