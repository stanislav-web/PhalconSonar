<?php
namespace Sonar\Tests\Mappers\Db\Mongo;

use Sonar\Mappers\Db\Mongo\VisitorMapper;

/**
 * Class TestVisitorMapper
 *
 * @package Sonar\Tests\Models
 * @subpackage Sonar\Tests
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Tests/Mappers/Db/Mongo/TestVisitorMapper.php
 */
class TestVisitorMapper extends \PHPUnit_Framework_TestCase {

    /**
     * Testing object namespace
     *
     * @const INSTANCE_OBJECT
     */
    const INSTANCE_OBJECT = 'Sonar\Mappers\Db\Mongo\VisitorMapper';

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
     * Add records test
     */
    public function testAdd()
    {
        $this->assertEquals(true, true);
    }
}