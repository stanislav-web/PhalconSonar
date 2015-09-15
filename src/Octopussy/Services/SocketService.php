<?php
namespace Octopussy\Services;

use Ratchet\App as Server;
use Ratchet\Server\EchoServer;
use Octopussy\Receiver;
use Octopussy\Exceptions\AppException;

/**
 * SocketService class. Client bridge service for locate incoming messages
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/SocketService.php
 */
class SocketService {

    /**
     * Socket configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * WebSocket server instance
     *
     * @var Server $server
     */
    private $server;

    /**
     * Implement configurations
     *
     * @param \Phalcon\Config $config $config
     */
    public function __construct(\Phalcon\Config $config) {
        $this->config = $config;
    }

    /**
     * Run the server application through the WebSocket protocol
     *
     * @return null
     */
    public function run() {

        if(!$this->server) {
            $this->server = new Server($this->config->socket->host, $this->config->socket->port);
        }

        if(isset($this->config->storage) === false) {
            throw new AppException('There is no option `storage` in your configurations');
        }

        $this->server->route('/chat', new Receiver(new StorageService($this->config->storage)));
        $this->server->route('/echo', new EchoServer);
        $this->server->run();
    }
}