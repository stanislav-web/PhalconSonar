<?php
namespace Octopussy\Tests\Models;

use Octopussy\Mockups\GeoMockup;
use Octopussy\Models\Geo;

/**
 * Class GeoTest
 *
 * @package Octopussy\Tests\Models
 * @subpackage Octopussy\Tests
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/GeoTest.php
 */
class GeoTest extends \PHPUnit_Framework_TestCase {

    /**
     * Testing object namespace
     *
     * @const INSTANCE_OBJECT
     */
    const INSTANCE_OBJECT = 'Octopussy\Models\Geo';

    /**
     * Get geo mockup
     *
     * @var \Octopussy\Mockups\GeoMockup
     */
    private $mock;

    /**
     * Constraint object
     *
     * @var \PHPUnit_Framework_Constraint
     */
    private $constraint;

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
