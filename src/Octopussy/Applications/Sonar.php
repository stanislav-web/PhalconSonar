<?php
namespace Octopussy\Applications;

use Phalcon\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Octopussy\Services\StorageService;
use Octopussy\Services\QueueService;
use Octopussy\System\Messenger;
use Octopussy\Exceptions\AppException;

/**
 * Sonar class. App receiver
 *
 * @package Octopussy
 * @subpackage Octopussy\Applications
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
     * Initialize client's storage
     *
     * @param StorageService $storageService
     * @param QueueService   $queueService
     */
    public function __construct(StorageService $storageService, QueueService $queueService) {

        $this->clients = new \SplObjectStorage;
        $this->storageService = $storageService;
        $this->queueService = $queueService;

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
     * @deprecated
     * @param ConnectionInterface $from
     * @param string              $msg
     * @throws \InvalidArgumentException
     */
    public function onMessage(ConnectionInterface $from, $msg) {


        if(is_array($msg = json_decode($msg, true)) === false) {
            throw new \InvalidArgumentException('The server received an invalid data format');
        }

        $data = array_merge([
            'ip'        => $this->getIpAddress($from),
            'ua'        => $this->getUserAgent($from),
            'language'  => $this->getLanguage($from),
            'open'      => time()
        ], $msg);


        // add client to storage
        $this->storageService->add($data);
    }

    /**
     * Close conversation event
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn) {

        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo Messenger::close($this->getIpAddress($conn));
    }

    /**
     * Error event emitter
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     * @throws \Octopussy\Exceptions\AppException;
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {

        try {

        }
        catch(\Exception $e) {
            throw new AppException(Messenger::error($e->getMessage()));
        }
        finally {
            $conn->close();
        }
    }

    /**
     * Get UserAgent
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getUserAgent(ConnectionInterface $conn) {

        $userAgent = $conn->WebSocket->request->getHeader('User-Agent')->toArray();
        return (empty($userAgent[0]) === false) ? $userAgent[0] : 'Unknown';
    }

    /**
     * Get visitor IP address
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getIpAddress(ConnectionInterface $conn) {

        $userIp = $conn->WebSocket->request->getHeader('X-Forwarded-For');
        return (empty($userIp) === false) ? $userIp : $conn->remoteAddress;
    }

    /**
     * Get visitor IP address
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getLanguage(ConnectionInterface $conn) {

        $language = $conn->WebSocket->request->getHeader('Accept-Language');
        $language = trim(strtoupper(substr($language, 0, 2)));

        return (empty($language) === false) ? $language :'Unknown';
    }

    /**
     * Get current page
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getCurrentPage(ConnectionInterface $conn) {
        $query = $conn->WebSocket->request->getQuery();
        return $query->get('page');
    }

}