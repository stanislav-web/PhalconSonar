<?php
namespace Octopussy\Services;

use Ratchet\App as Look;
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
     * Look server (load lazy)
     *
     * @var Look $look
     */
    private $look;

    /**
     * Run the server application through the WebSocket protocol
     *
     * @param string $host
     * @param string $port
     * @return null
     */
    public function run($storage, $host, $port) {

        if(!$this->look) {
            $this->look = new Look($host, $port);
        }

        $this->look->route('/chat', new PushCollector);
        $this->look->route('/echo', new EchoServer);
        $this->look->run();
    }
}