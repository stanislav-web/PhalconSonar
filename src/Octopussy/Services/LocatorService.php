<?php
namespace Octopussy\Services;

use Ratchet\App;
use Octopussy\PushCollector;
use Ratchet\Server\EchoServer;

/**
 * LocatorService class. Client bridge service for locate incoming messages
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/LocatorService.php
 */
class LocatorService {

    /**
     * Module configuration
     *
     * @var array $config
     */
    private $config = [];

    /**
     * Initial module configuration params
     *
     * @param array $config
     */
    public function __construct(array $config) {

        if(empty($this->config) === true) {
            $this->config = $config;
        }
    }

    /**
     * Get configurations
     *
     * @return object
     */
    public function getConfig()
    {
        return (object)$this->config;
    }

    /**
     * Set configurations
     *
     * @param array $config
     * @return LocatorService
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Run the server application through the WebSocket protocol
     *
     * @return null
     */
    public function run() {

        $app = new App($this->getConfig()->host, $this->getConfig()->port);
        $app->route('/chat', new PushCollector);
        $app->route('/echo', new EchoServer);
        $app->run();
    }
}