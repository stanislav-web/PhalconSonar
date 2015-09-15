<?php
namespace Octopussy\Applications;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Phalcon\Http\Request;
use Octopussy\Services\StorageService;
use Octopussy\System\Messenger;

/**
 * Grabber class. App receiver
 *
 * @package Octopussy
 * @subpackage Octopussy\Applications
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Applications/Grabber.php
 */
class Grabber implements MessageComponentInterface {

    /**
     * Client's storage
     *
     * @var \SplObjectStorage $clients
     */
    protected $clients;

    /**
     * Storage service
     *
     * @var \Octopussy\Services\StorageService $storageService
     */
    private $storageService;

    /**
     * Initialize client's storage
     */
    public function __construct(StorageService $storageService) {

        $this->clients = new \SplObjectStorage;
        $this->storageService = $storageService;

        echo Messenger::start();
    }

    /**
     * Open task event
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection
        $this->clients->attach($conn);

        // Write client to storage
        $this->storageService->save(['ip' => $this->getIpAddress($conn), 'ua' => $this->getUserAgent($conn), 'time' => (new Request())->getServer('REQUEST_TIME')]);
        echo Messenger::open($this->getIpAddress($conn));
    }

    /**
     * Push to task event
     *
     * @param ConnectionInterface $from
     * @param string              $msg
     */
    public function onMessage(ConnectionInterface $from, $msg) {

        echo Messenger::message($from->remoteAddress, $msg);

        // The sender is not the receiver, send to each client connected
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
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

        echo Messenger::close($this->getIpAddress($conn));
    }

    /**
     * Error event emitter
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {

        echo Messenger::error($e->getMessage());
        $conn->close();
    }

    /**
     * Get UserAgent
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getUserAgent(ConnectionInterface $conn) {

        $userAgent = $conn->WebSocket->request->getHeader('User-Agent')->toArray();

        if(empty($userAgent) === false) {
            return $userAgent[0];
        }

        return 'Unknown';
    }

    /**
     * Get visitor IP address
     *
     * @param ConnectionInterface $conn
     * @return string
     */
    private function getIpAddress(ConnectionInterface $conn) {

        $userIp = $conn->WebSocket->request->getHeader('x-forwarded-for');
        $ip = !empty($userIp) ? $userIp : $conn->remoteAddress;

        return $ip;
    }
}