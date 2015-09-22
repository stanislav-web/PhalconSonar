<?php
namespace Sonar\Aware;

use Sonar\Exceptions\E;
use Sonar\Exceptions\MongoMapperException;

/**
 * Class AbstractMongoMapper. Abstract mapper for mongoDb client
 *
 * @package Sonar\Aware
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Aware/AbstractMongoMapper.php
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
     * @throws \Sonar\Exceptions\StorageServiceException
     */
    public function __construct(\Phalcon\Config $config) {

        try {

            if (!$this->db) {
                // init client
                $this->client = new \MongoClient($this->getConnectUri($config));

                // select database
                $this->db = $this->client->selectDB($config['dbname']);
            }

            // select collection
            $this->setCollection();

        }
        catch (\MongoConnectionException $e) {
            throw new MongoMapperException($e->getMessage());
        }
    }

    /**
     * Get mongo connection URI
     *
     * @param \Phalcon\Config $config
     * @return string
     */
    private function getConnectUri(\Phalcon\Config $config) {

        if($config->offsetExists('user') && $config->offsetExists('password')) {
            return "mongodb://".$config['user'].":".$config['password']."@".$config['host'].":".$config['port']."/".$config['dbname'];
        }
        else {
            return "mongodb://".$config['host'].":".$config['port']."/".$config['dbname'];
        }
    }

    /**
     * Set using collection
     *
     * @return \Sonar\Aware\AbstractMongoMapper
     */
    protected function setCollection() {

        $this->collection = $this->db->selectCollection(static::COLLECTION);

        return $this;
    }

    /**
     * Add records to collection
     *
     * @param array $data
     * @throws \Sonar\Exceptions\MongoMapperException
     * @return \MongoId
     */
    abstract public function add(array $data);
}