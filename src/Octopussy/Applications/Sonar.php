<?php
namespace Octopussy\Applications;

use Phalcon\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Octopussy\Services\StorageService;
use Octopussy\System\Messenger;

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
     * Storage service
     *
     * @var \Octopussy\Services\StorageService $storageService
     */
    private $storageService;

    /**
     * Initialize client's storage
     */
    public function __construct(StorageService $storageService, \Phalcon\Config $config) {

        $this->clients = new \SplObjectStorage;
        $this->storageService = $storageService;

        echo Messenger::start($config->socket->host, $config->socket->port);
    }

    /**
     * Open task event
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {

        // store the new connection
        $this->clients->attach($conn);

        // add client to storage
        $this->storageService->add([
            'ip'        => $this->getIpAddress($conn),
            'ua'        => $this->getUserAgent($conn),
            'language'  => $this->getLanguage($conn),
            'page'      => $this->getCurrentPage($conn),
            'time'      => time()
        ]);

        echo Messenger::open($this->getIpAddress($conn));
    }

    /**
     * Push to task event
     *
     * @deprecated
     * @param ConnectionInterface $from
     * @param string              $msg
     */
    public function onMessage(ConnectionInterface $from, $msg) {
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