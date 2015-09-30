<?php
namespace Sonar\Applications;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Sonar\Exceptions\SocketServiceException;
use Sonar\Services\CacheService;
use Sonar\Services\GeoService;
use Sonar\Services\StorageService;
use Sonar\Services\QueueService;
use Sonar\System\Messenger;
use Sonar\Exceptions\AppServiceException;
use Sonar\System\Profiler;

/**
 * Class Sonar. App receiver
 *
 * @package Sonar\Applications
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Applications/Sonar.php
 */
class Sonar implements MessageComponentInterface {

    /**
     * Client's storage
     *
     * @var \SplObjectStorage $clients
     */
    protected $clients;

    /**
     * Db Storage service
     *
     * @var \Sonar\Services\StorageService $storageService
     */
    private $storageService;

    /**
     * Queue service
     *
     * @var \Sonar\Services\QueueService $queueService
     */
    private $queueService;

    /**
     * Geo location service
     *
     * @var \Sonar\Services\GeoService $geoService
     */
    private $geoService;

    /**
     * Implemented cache
     *
     * @var null|\Sonar\Services\CacheService $cacheService
     */
    private $cacheService;

    /**
     * Initialize client's storage
     *
     * @param StorageService $storageService
     * @param QueueService   $queueService
     * @param GeoService     $geoService
     * @param CacheService|null   $cacheService
     */
    public function __construct(
        StorageService $storageService,
        QueueService $queueService,
        GeoService $geoService,
        CacheService $cacheService = null) {

        $this->clients = new \SplObjectStorage;
        $this->storageService = $storageService;
        $this->queueService = $queueService;
        $this->geoService = $geoService;
        $this->cacheService = $cacheService;

        echo Messenger::start();
    }

    /**
     * Open task event
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {

        // store the new connection
        $this->clients->attach($conn);

        echo Messenger::open($this->getIpAddress($conn));

        // start profiler
        if(defined('SONAR_VERBOSE') === true) {
            Profiler::start();
        }
    }

    /**
     * Push to task event
     *
     * @param ConnectionInterface           $conn
     * @param ConnectionInterface           $request
     * @throws \Sonar\Exceptions\AppServiceException
     */
    public function onMessage(ConnectionInterface $conn, $request) {

        if(is_array($request = json_decode($request, true)) === false) {
            throw new AppServiceException('The server received an invalid data format');
        }
        if(isset($request['page']) === false) {
            throw new AppServiceException('There is no current page data');
        }

        $this->queueService->push($request, function() use ($request, $conn) {

            // process only what is necessary for the subsequent construction of stats
            return [
                'ip'        =>  $this->getIpAddress($conn),
                'hash'      =>  md5($this->getIpAddress($conn).$this->getUserAgent($conn)),
                'open'      =>  time()
            ];
        });

        // send back
        if(defined('SONAR_VERBOSE') === true) {
            echo Messenger::message(json_encode($request));
            $conn->send(json_encode($request));
        }
    }

    /**
     * Close conversation event
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn) {

        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        // pulled data from queues
        $data = $this->queueService->pull([
            // identity for open queue message
                'hash'        =>  md5($this->getIpAddress($conn).$this->getUserAgent($conn)),
            ], function($response) use ($conn) {

            return array_merge($response, [
                'ua'            => $this->getUserAgent($conn),
                'language'      => $this->getLanguage($conn),
                'location'      => $this->getLocation($conn),
                'close'         => time()
            ]);
        });

        // save data to storage
        $this->storageService->add($data);

        echo Messenger::close($this->getIpAddress($conn));

        // end profiler
        if(defined('SONAR_VERBOSE') === true) {
            Profiler::finish();
            Profiler::getProfilingData();
        }
    }

    /**
     * Error event emitter
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     * @throws \Sonar\Exceptions\AppServiceException
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {

        try {
            throw new \Exception($e->getMessage());
        }
        catch(\Exception $e) {
            throw new SocketServiceException(Messenger::error($e->getMessage()));
        }
        finally {
            $conn->close();
        }
    }

    /**
     * Get UserAgent
     *
     * @param ConnectionInterface $conn
     * @throws \Sonar\Exceptions\AppServiceException
     * @return string
     */
    private function getUserAgent(ConnectionInterface $conn) {

        if($conn->WebSocket instanceof \StdClass) {
            $userAgent = $conn->WebSocket->request->getHeader('User-Agent')->toArray();

            return (empty($userAgent[0]) === false) ? $userAgent[0] : 'Unknown';
        }
        throw new AppServiceException('Define user agent failed');
    }

    /**
     * Get visitor IP address
     *
     * @param ConnectionInterface $conn
     * @throws \Sonar\Exceptions\AppServiceException
     * @return string
     */
    private function getIpAddress(ConnectionInterface $conn) {

        if($conn->WebSocket instanceof \StdClass) {

            $userIp = $conn->WebSocket->request->getHeader('X-Forwarded-For');

            return (empty($userIp) === false) ? $userIp : $conn->remoteAddress;
        }
        throw new AppServiceException('Define ip failed');
    }

    /**
     * Get visitor IP address
     *
     * @param ConnectionInterface $conn
     * @throws \Sonar\Exceptions\AppServiceException
     * @return string
     */
    private function getLanguage(ConnectionInterface $conn) {

        if($conn->WebSocket instanceof \StdClass) {
            $language = $conn->WebSocket->request->getHeader('Accept-Language');
            $language = trim(strtoupper(substr($language, 0, 2)));

            return (empty($language) === false) ? $language :'Unknown';
        }
        throw new AppServiceException('Language not defined');
    }

    /**
     * Get user location
     *
     * @param ConnectionInterface $conn
     * @throws \Sonar\Exceptions\AppServiceException
     * @return string
     */
    private function getLocation(ConnectionInterface $conn) {

        if($conn->WebSocket instanceof \StdClass) {

            if(($cache = $this->cacheService) != null) {

                $ip = $this->getIpAddress($conn);

                // load geo location from cache
                if($cache->getStorage()->exists($ip) === true) {
                    $location = $cache->getStorage()->get($ip);
                }

                // add to cache geo location
                $cache->getStorage()->save($ip, $this->geoService->location($ip));
            }
            else {
                $location = $this->geoService->location($this->getIpAddress($conn));
            }

            return $location;
        }
        throw new AppServiceException('Language not defined');
    }
}