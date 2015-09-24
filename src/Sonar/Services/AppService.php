<?php
namespace Sonar\Services;

use Sonar\Exceptions\AppServiceException;
use Sonar\Exceptions\SocketServiceException;

/**
 * Class AppService. Application Service
 *
 * @package Sonar\Services
 * @subpackage Sonar
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Services/AppService.php
 */
class AppService {

    /**
     * Socket service
     *
     * @var \Sonar\Services\SocketService $socketService
     */
    private $socketService;

    /**
     * Initial module configuration params
     *
     * @param \Phalcon\Config $config
     * @throws \Sonar\Exceptions\AppServiceException
     */
    public function __construct(\Phalcon\Config $config) {

        if(!$this->socketService) {

            if(isset($config->socket) === false) {
                throw new AppServiceException('There is no option `socket` in your configurations');
            }

            if($config->offsetExists('debug') === true) {
                define('VERBOSE', $config->debug);
            }
            $this->socketService = new SocketService($config);
        }
    }

    /**
     * Run socket server
     * @throws \Sonar\Exceptions\AppServiceException
     */
    public function run() {

        if (PHP_SAPI !== 'cli') {
            throw new AppServiceException('Warning: Script should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI');
        }
        try {
            $this->socketService->run();
        }
        catch(SocketServiceException $e) {
            throw new AppServiceException($e->getMessage());
        }
    }

}