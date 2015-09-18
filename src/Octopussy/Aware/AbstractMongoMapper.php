<?php
namespace Octopussy\Aware;

/**
 * AbstractMongoMapper class. Abstract mapper for mongoDb client
 *
 * @package Octopussy
 * @subpackage Octopussy\Aware
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Aware/AbstractMongoMapper.php
 */
abstract class AbstractMongoMapper {

    /**
     * MongoDB client connection
     *
     * @var \MongoClient $client
     */
    protected $client;

    /**
     * Database instance
     *
     * @var \MongoDB
     */
    protected $db;

    /**
     * Collection instance
     *
     * @var \MongoCollection
     */
    protected $collection;

    /**
     * Implement configurations for MongoDB connection
     *
     * @param \Phalcon\Config $config
     * @throws \Octopussy\Exceptions\StorageException
     */
    public function __construct(\Phalcon\Config $config) {

        $uri = "mongodb://".$config['user'].":".$config['password']."@".$config['host'].":".$config['port']."/".$config['dbname'];

        try {

            if(!$this->db) {
                // init client
                $this->client = new \MongoClient($uri);

                // select database
                $this->db = $this->client->selectDB($config['dbname']);
            }

            // select collection
            $this->setCollection();

        }
        catch(\MongoConnectionException $e) {
            throw new StorageException($e->getMessage());
        }
    }

    /**
     * Set using collection
     *
     * @return \Octopussy\Aware\AbstractMapperBase
     */
    protected function setCollection() {

        $this->collection = $this->db->selectCollection(static::COLLECTION);

        return $this;
    }

    /**
     * Add records to collection
     *
     * @param array $data
     * @throws \Octopussy\Exceptions\VisitorMapperException
     * @return \MongoId
     */
    abstract public function add(array $data);

    /**
     * Remove records from collection
     *
     * @param array $criteria
     * @throws \Octopussy\Exceptions\VisitorMapperException
     */
    abstract public function remove(array $criteria);
}