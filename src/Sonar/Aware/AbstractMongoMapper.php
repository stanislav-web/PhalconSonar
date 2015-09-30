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

    const PROFILE_OFF = 0;
    const PROFILE_SLOW = 1;
    const PROFILE_ALL = 2;

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
     * @throws \MongoConnectionException
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
            throw new \MongoConnectionException($e->getMessage());
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
     * Set MongoDb profiler
     *
     * @param int $level 0, 1, 2
     * @param int $slowms slow queries in ms.
     * @return array
     */
    public function setProfiler($level = self::PROFILE_ALL, $slowms = 100) {

        return $this->db->command([
            'profile' => (int)$level,
            'slowms'  => (int)$slowms
        ]);
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