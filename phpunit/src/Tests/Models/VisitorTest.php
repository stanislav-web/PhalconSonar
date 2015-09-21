<?php
namespace Octopussy\Tests\Models;

use Octopussy\Mockups\VisitorMockup;
use Octopussy\Models\Visitor;

/**
 * Class VisitorTest
 *
 * @package Octopussy\Tests\Models
 * @subpackage Octopussy\Tests
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/VisitorTest.php
 */
class VisitorTest extends \PHPUnit_Framework_TestCase {

    /**
     * Testing object namespace
     *
     * @const INSTANCE_OBJECT
     */
    const INSTANCE_OBJECT = 'Octopussy\Models\Visitor';

    /**
     * Get visitor mockup
     *
     * @var \Octopussy\Mockups\VisitorMockup
     */
    private $mock;

    /**
     * Initialize testing object
     *
     * @uses VisitorMock
     */
    public function setUp()
    {
        $this->mock = new VisitorMockup();
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

        $data = new Visitor($this->mock->getMockData());

        // checking instance object return
        $this->assertInstanceOf(self::INSTANCE_OBJECT, $data);
    }

    /*
     * Model attributes testing
     */
    public function testHasAttributes()
    {
        $data = new Visitor($this->mock->getMockData());

        // just checking that the attributes exists & equal too
        $this->assertSame(
            array_diff($this->mock->getReturnedResultKeys(), array_keys($data->toArray())),
            array_diff(array_keys($data->toArray()), $this->mock->getReturnedResultKeys()));
    }
}
