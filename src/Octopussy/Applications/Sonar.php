<?php
namespace Octopussy\Applications;

use Octopussy\Services\GeoService;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Octopussy\Services\StorageService;
use Octopussy\Services\QueueService;
use Octopussy\System\Messenger;
use Octopussy\Exceptions\AppServiceException;

error_reporting(E_ALL & ~E_WARNING);
ini_set('display_errors', 'On');

/**
 * Class Sonar. App receiver
 *
 * @package Octopussy\Applications
 * @subpackage Octopussy
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Applications/Sonar.php
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
     * @var \Octopussy\Services\StorageService $storageService
     */
    private $storageService;

    /**
     * Queue service
     *
     * @var \Octopussy\Services\QueueService $queueService
     */
    private $queueService;

    /**
     * Geo location service
     *
     * @var \Octopussy\Services\GeoService $geoService
     */
    private $geoService;

    /**
     * Initialize client's storage
     *
     * @param StorageService $storageService
     * @param QueueService   $queueService
     * @param GeoService     $geoService
     */
    public function __construct(StorageService $storageService, QueueService $queueService, GeoService $geoService) {

        $this->clients = new \SplObjectStorage;
        $this->storageService = $storageService;
        $this->queueService = $queueService;
        $this->geoService = $geoService;

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
    }

    /**
     * Push to task event
     *
     * @param ConnectionInterface $request
     * @param string              $conn
     * @throws \InvalidArgumentException
     */
    public function onMessage(ConnectionInterface $conn, $request) {

        if(is_array($request = json_decode($request, true)) === false) {
            throw new AppServiceException('The server received an invalid data format');
        }

        $this->queueService->push($request, function() use ($conn) {

            // process only what is necessary for the subsequent construction of stats
            return [
                'ip'        =>  $this->getIpAddress($conn),
                'hash'      =>  md5($this->getIpAddress($conn).$this->getUserAgent($conn)),
                'open'      =>  time()
            ];
        });
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
    }

    /**
     * Error event emitter
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     * @throws \Octopussy\Exceptions\AppServiceException
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {

        try {}
        catch(\Exception $e) {
            throw new AppServiceException(Messenger::error($e->getMessage()));
        }
        finally {
            $conn->close();
        }
    }

    /**
     * Get UserAgent
     *
     * @param ConnectionInterface $conn
     * @throws \Octopussy\Exceptions\AppServiceException
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
     * @throws \Octopussy\Exceptions\AppServiceException
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
     * @throws \Octopussy\Exceptions\AppServiceException
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
     * @throws \Octopussy\Exceptions\AppServiceException
     * @return string
     */
    private function getLocation(ConnectionInterface $conn) {

        if($conn->WebSocket instanceof \StdClass) {

            //@TODO location
            //$this->getIpAddress($conn);
            $location = $this->geoService->location('195.12.23.15');
            //var_dump($location->all());
            return '';
        }
        throw new AppServiceException('Language not defined');
    }
}