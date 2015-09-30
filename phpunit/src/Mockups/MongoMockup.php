<?php
namespace Sonar\Mockups;

use Phalcon\Config;

/**
 * Class MongoMockup
 *
 * @package Sonar\Mockups
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Mockups/MongoMockup.php
 */
class MongoMockup {

    /**
     * Add data
     *
     * @var array $addData
     */
    private $addData = [];

    /**
     * @param array $addData
     */
    public function __construct(array $addData) {
        $this->addData = $addData;
    }

    /**
     * Get config
     *
     * @return \Phalcon\Config
     */
    public function getConfig() {

        return new Config([
            'host'      =>  '127.0.0.1',
            'port'      =>  27017,
            'user'      =>  '',
            'password'  =>  '',
            'dbname'    =>  'sonar_test',
        ]);
    }

    /**
     * @return array
     */
    public function getAddData() {
        return $this->addData;
    }

}