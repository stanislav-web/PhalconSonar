<?php
namespace Sonar\Mockups;

/**
 * Class VisitorMock
 *
 * @package Sonar\Mockups
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Mockups/VisitorMockup.php
 */
class VisitorMockup {

    /**
     * Get Visitors mock data
     *
     * @return array
     */
    public function getMockData() {

        return [
            'page'      => 'http://redumbrella.com.ua',
            'ip'        => "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255),
            'open'      => time(),
            'location'  => [],
            'close'     => time() + mt_rand(0, 1000),
            'language'  => array_rand(['RU', 'UA', 'DE', 'US'], 1)[0],
            'ua'        => 'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/532.0 (KHTML, like Gecko) Chrome/4.0.212.0 Safari/532.0'
        ];
    }

    /**
     * Get returned result keys
     *
     * @return array
     */
    public function getReturnedResultKeys() {

        return [
            'ip',
            'ua',
            'browser',
            'language',
            'platform',
            'mobile',
            'tablet',
            'pc',
            'page',
            'open',
            'close',
            'location'
        ];
    }

}