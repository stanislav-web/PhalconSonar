<?php
#namespace Octopussy\System\Tasks;

use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger;
use Phalcon\CLI\Task;
use Phalcon\Script\Color;
use Octopussy\Services\AppService as Application;
use Octopussy\Exceptions\AppException;

error_reporting(7);
ini_set('display_errors', 'On');

/**
 * Class SonarTask. Grab user's visits
 *
 * @package Octopussy
 * @subpackage Octopussy\System\Tasks
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/System/Tasks/SonarTask.php
 */
class SonarTask extends Task
{

    /**
     * Default task name
     *
     * @var string $taskName
     */
    private $taskName = 'sonar';

    /**
     * Task configuration
     *
     * @var \Phalcon\Config $config
     */
    private $config;

    /**
     * Octopussy configuration
     *
     * @var \Octopussy\Services\AppService $sonar
     */
    private $sonar;

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
     * @return SonarTask
     */
    private function setConfig(\Phalcon\Config $config)  {

        if(defined(CURRENT_TASK) === true) {
            $this->taskName = CURRENT_TASK;
        }

        $this->config = $config->cli->{$this->taskName};

        return $this;
    }

    /**
     * Get current task configurations
     *
     * @return \Phalcon\Config
     */
    private function getConfig() {
        return $this->config;
    }

    /**
     * Setup file logger
     *
     * @return SonarTask
     */
    private function setLogger() {

        $this->logger = new FileAdapter($this->getConfig()->logfile);

        return $this;
    }

    /**
     * Get logger
     *
     * @return \Phalcon\Logger\Adapter\File
     */
    private function getLogger() {
        return $this->logger;
    }

    /**
     * Initialize task
     */
    public function mainAction()
    {

        try {

            // init configurations // init logger
            $this->setConfig($this->getDI()->get('config'))->setLogger();

            // run server
            $this->sonar = new Application($this->getConfig());

            $this->sonar->run();

        }
        catch(AppException $e) {

            echo Color::colorize($e->getMessage(), Color::FG_RED, Color::AT_BOLD).PHP_EOL;
            $this->getLogger()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
}