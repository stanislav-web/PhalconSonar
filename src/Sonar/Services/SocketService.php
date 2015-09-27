<?php
namespace Sonar\Services;

use React\Socket\ConnectionException;
use Ratchet\App as AppServer;
use Sonar\Applications\Sonar;
use Sonar\Exceptions\QueueServiceException;
use Sonar\Exceptions\AppServiceException;
use Sonar\Exceptions\SocketServiceException;
use Sonar\Exceptions\StorageServiceException;
use Sonar\Exceptions\CacheServiceException;

/**
 * Class SocketService. Client bridge service for locate incoming messages
 *
 * @package Sonar\Services
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Services/SocketService.php
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
     * @var AppServer $server
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
     * @throws \Sonar\Exceptions\AppServiceException
     * @throws \Sonar\Exceptions\SocketServiceException
     * @return null
     */
    public function run() {

        if(!$this->server) {

            try {

                // initialize socket server
                $this->server = new AppServer($this->config->socket->host, $this->config->socket->port);

                // create application with dependencies
                $app = new Sonar(
                    new StorageService($this->config->storage),
                    new QueueService($this->config->beanstalk),
                    new GeoService(),
                    new CacheService()
                );
                $this->server->route('/sonar', $app, ['*']);
            }
            catch(QueueServiceException $e) {
                throw new AppServiceException($e->getMessage());
            }
            catch(ConnectionException $e) {
                throw new SocketServiceException($e->getMessage());
            }
            catch(StorageServiceException $e) {
                throw new AppServiceException($e->getMessage());
            }
            catch(CacheServiceException $e) {
                throw new AppServiceException($e->getMessage());
            }

        }

        if(isset($this->config->storage) === false) {
            throw new AppServiceException('There is no option `storage` in your configurations');
        }

        $this->server->run();
    }
}