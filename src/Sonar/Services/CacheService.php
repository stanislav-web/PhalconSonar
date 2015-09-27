<?php
namespace Sonar\Services;

use Sonar\Exceptions\CacheServiceException;
use Phalcon\Cache\Backend\Memory;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Exception as CacheException;
/**
 * Class CacheService. Cache data service base on Shared Memory
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
     * SharedMemory instance
     *
     * @var \Phalcon\Cache\Backend\Memory $instance
     */
    private $instance;

    /**
     * Implement cache configurations
     */
    public function __construct() {

        try {

            if(!$this->instance) {

                $this->instance = new Memory(new Data());

            }
        }
        catch(CacheException $e) {
            throw new CacheServiceException($e->getMessage());
        }
    }

    /**
     * Return cache storage instance
     *
     * @return \Phalcon\Cache\Backend\Memory
     */
    public function getStorage() {
        return $this->instance;
    }
}