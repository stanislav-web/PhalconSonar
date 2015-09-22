<?php
namespace Sonar\Services;

use Ratchet\Session\SessionProvider;
use Ratchet\MessageComponentInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcacheSessionHandler;

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
     * @var \Memcache $cache
     */
    private $cache;

    /**
     * Session provider instance
     *
     * @var \Ratchet\Session\SessionProvider $provider
     */
    private $provider;

    /**
     * Implement chache configurations
     */
    public function __construct(\Phalcon\Config $config) {

        $this->cache = new \Memcache();
        $this->cache->connect($config->host, $config->port);
    }

    /**
     * Add application to cache storage
     *
     * @param \MessageComponentInterface $app
     * @return \Ratchet\Session\SessionProvider
     */
    public function addApplication(\MessageComponentInterface $app) {

        if(!$this->provider) {
            $this->provider = new SessionProvider($app,  new MemcacheSessionHandler($this->cache));
        }

        return $this->provider;
    }
}