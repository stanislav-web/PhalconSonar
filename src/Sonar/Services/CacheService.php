<?php
namespace Sonar\Services;

use Sonar\Exceptions\CacheServiceException;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Exception as CacheException;
/**
 * Class CacheService. Cache data service
 *
 * @package Sonar\Services
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Services/CacheService.php
 */
class CacheService {

    /**
     * Memcache connect
     *
     * @var \Phalcon\Cache\Backend\Memcache $connect
     */
    private $connect;

    /**
     * Implement chache configurations
     */
    public function __construct(\Phalcon\Config $config) {

        try {

            if(!$this->connect) {

                $this->connect = new Memcache(new Data(['lifetime' => $config->lifetime]), [
                    'host'      =>  $config->host,
                    'port'      =>  $config->port,
                    'prefix'    =>  $config->prefix,
                    'persistent'=>  $config->persistent,
                ]);

            }
        }
        catch(CacheException $e) {
            throw new CacheServiceException($e->getMessage());
        }
    }

    /**
     * Return cache storage instance
     *
     * @return \Phalcon\Cache\Backend\Memcache
     */
    public function getStorage() {
        return $this->connect;
    }
}