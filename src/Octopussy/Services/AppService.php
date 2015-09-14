<?php

namespace Octopussy\Services;

/**
 * AppService class. Application Service
 *
 * @package Octopussy
 * @subpackage Octopussy\Services
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Services/AppService.php
 */
class AppService {

    /**
     * Module configuration
     *
     * @var array $config
     */
    private $config;

    /**
     * Locator Service
     *
     * @var \Octopussy\Services\LocatorService $locatorService
     */
    private $locatorService;

    /**
     * Storage service
     *
     * @var \Octopussy\Services\StorageService $storageService
     */
    private $storageService;

    /**
     * Initial module configuration params
     *
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config) {

        if(!$this->config) {
            $this->setConfig($config);
        }

        if(!$this->storageService) {
            $this->storageService = new StorageService($this->config->storage);
        }

        if(!$this->locatorService) {
            $this->locatorService = new LocatorService();
        }
    }

    /**
     * Get configurations
     *
     * @return object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set configurations
     *
     * @param array $config
     * @return LocatorService
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Run service
     */
    public function run() {
        $this->locatorService->run($this->storageService, $this->config->host, $this->config->port);
    }
}