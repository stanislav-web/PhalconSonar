<?php
namespace Octopussy\Services;

use Octopussy\Exceptions\QueueServiceException;
use Ratchet\Server\IoServer as Server;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use React\Socket\ConnectionException;
use Octopussy\Applications\Sonar;
use Octopussy\Exceptions\AppServiceException;
use Octopussy\Exceptions\SocketServiceException;

/**
 * Class SocketService. Client bridge service for locate incoming messages
 *
 * @package Octopussy\Services
 * @subpackage Octopussy
 * @since PHP >=5.5
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
     * @throws \Octopussy\Exceptions\AppServiceException
     * @throws \Octopussy\Exceptions\SocketServiceException
     * @return null
     */
    public function run() {

        if(!$this->server) {

            try {

                $this->server = Server::factory(new HttpServer(new WsServer(
                    new Sonar(
                        new StorageService($this->config->storage),
                        new QueueService($this->config->beanstalk),
                        new GeoService()
                    )
                )), $this->config->socket->port);

            }
            catch(QueueServiceException $e) {
                throw new AppServiceException($e->getMessage());
            }
            catch(ConnectionException $e) {
                throw new SocketServiceException($e->getMessage());
            }
            catch (\RuntimeException $e) {
                throw new SocketServiceException($e->getMessage());
            }
        }

        if(isset($this->config->storage) === false) {
            throw new AppServiceException('There is no option `storage` in your configurations');
        }

        $this->server->run();
    }
}