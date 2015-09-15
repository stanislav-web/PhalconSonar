<?php
namespace Octopussy\System\Tasks;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\CLI\Task;
use Octopussy\Services\AppService as Application;
use Octopussy\Exceptions\AppException;

/**
 * Class GrabberTask. Grab user visits
 *
 * @package Octopussy
 * @subpackage Octopussy\System\Tasks
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/System/Tasks/GrabberTask.php
 */
class ReceiverTask extends Task
{
    /**
     * Task configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Octopussy configuration
     *
     * @var \Octopussy\Services\AppService $grabber
     */
    private $grabber;

    /**
     * Logger
     *
     * @var \Phalcon\Logger\Adapter\File $logger
     */
    private $logger;

    /**
     * Setup current task configurations
     *
     * @param \Phalcon\Config $config
     * @return \Octopussy\System\Tasks\ReceiverTask
     */
    public function setConfig(\Phalcon\Config $config)  {

        $this->config = $config->cli->{CURRENT_TASK};

        return $this;
    }

    /**
     * Get current task configurations
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * Setup file logger
     *
     * @return \Octopussy\System\Tasks\ReceiverTask
     */
    public function setLogger() {

        $this->logger = new FileAdapter($this->getConfig()->logfile);

        return $this;
    }

    /**
     * Get logger
     *
     * @return \Phalcon\Logger\Adapter\File
     */
    public function getLogger() {
        return $this->logger;
    }

    /**
     * Console style helper
     *
     * @return  \Phalcon\Script\Color
     */
    public function styleHelper() {
        return $this->getDI()->get('color');
    }

    /**
     * Initialize task
     */
    public function mainAction()
    {

        try {

            // init configurations // init logger
            $this->setConfig($this->getDI()->get('config'))->setLogger()->setDb();

            // run server
            $this->grabber = new Application($this->getConfig());
            $this->grabber->run();

        }
        catch(AppException $e) {
            echo $this->styleHelper()->error($e->getMessage());
            $this->logger->log($e->getMessage(), \Phalcon\Logger::CRITICAL);
        }
    }
}