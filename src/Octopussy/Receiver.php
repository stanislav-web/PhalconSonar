<?php
namespace Octopussy;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Octopussy\Services\StorageService;

/**
 * Receiver class. WebSocket bridge
 *
 * @package Octopussy
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Receiver.php
 */
class Receiver implements MessageComponentInterface {

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
    }

    /**
     * Open task event
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    /**
     * Push to task event
     *
     * @param ConnectionInterface $from
     * @param string              $msg
     */
    public function onMessage(ConnectionInterface $from, $msg) {
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
        $this->clients->detach($conn);
    }

    /**
     * Error event emitter
     *
     * @param ConnectionInterface $conn
     * @param \Exception          $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}