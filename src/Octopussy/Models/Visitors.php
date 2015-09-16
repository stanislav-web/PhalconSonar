<?php

namespace Octopussy\Models;

/**
 * Visitors class. Visitor's ODM
 *
 * @package Octopussy
 * @subpackage Octopussy\Models
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/Visitors.php
 */
class Visitors {

    /**
     * Collection name
     *
     * @const COLLECTION
     */
    const COLLECTION = 'visitors';

    /**
     * IP Address
     *
     * @var int $ip
     */
    public $ip;

    /**
     * User Agent
     *
     * @var string $ua
     */
    public $ua;

    /**
     * Request time
     *
     * @var int $time
     */
    public $time;
}