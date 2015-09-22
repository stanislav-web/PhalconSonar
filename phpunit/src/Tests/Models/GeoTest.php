<?php
namespace Sonar\Tests\Models;

use Sonar\Mockups\GeoMockup;
use Sonar\Models\Geo;

/**
 * Class GeoTest
 *
 * @package Sonar\Tests\Models
 * @subpackage Sonar\Tests
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Tests/Models/GeoTest.php
 */
class GeoTest extends \PHPUnit_Framework_TestCase {

    /**
     * Testing object namespace
     *
     * @const INSTANCE_OBJECT
     */
    const INSTANCE_OBJECT = 'Sonar\Models\Geo';

    /**
     * Get geo mockup
     *
     * @var \Sonar\Mockups\GeoMockup
     */
    private $mock;

    /**
     * Initialize testing object
     *
     * @uses VisitorMock
     */
    public function setUp()
    {
        $this->mock = new GeoMockup();
    }

    /**
     * Kill testing object
     *
     * @uses VisitorMock
     */
    public function tearDown()
    {
        $this->mock = null;
    }

    /**
     * Instance testing
     */
    public function testInstance() {

        $data = new Geo($this->mock->getMockData());

        // checking instance object return
        $this->assertInstanceOf(self::INSTANCE_OBJECT, $data);
    }

    /*
     * Model attributes testing
     */
    public function testHasAttributes()
    {
        $data = new Geo($this->mock->getMockData());

        // just checking that the attributes exists & equal too
        $this->assertSame(
            array_diff($this->mock->getReturnedResultKeys(), array_keys($data->toArray())),
            array_diff(array_keys($data->toArray()), $this->mock->getReturnedResultKeys()));
    }

}
