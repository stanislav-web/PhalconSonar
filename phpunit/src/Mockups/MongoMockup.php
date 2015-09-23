<?php
namespace Sonar\Mockups;

/**
 * Class MongoMockup
 *
 * @package Sonar\Mockups
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Mockups/MongoMockup.php
 */
class MongoMockup {

    public function getConfig() {

        return \Phalcon\Config([
            'host'      =>  '127.0.0.1',
            'port'      =>  27017,
            'user'      =>  'root',
            'password'  =>  'root',
            'dbname'    =>  'sonar',
        ]);
    }

}