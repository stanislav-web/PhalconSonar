<?php
namespace Sonar\Tests\Mappers\Db\Mongo;

use Sonar\Mappers\Db\Mongo\VisitorMapper;
use Sonar\Mockups\MongoMockup;

/**
 * Class TestVisitorMapper
 *
 * @package Sonar\Tests\Mappers\Db\Mongo
 * @subpackage Sonar\Tests\Mappers\Db
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
     * @var \Sonar\Mockups\MongoMockup
     */
    private $mock;

    /**
     * Initialize testing object
     *
     * @uses VisitorMock
     */
    public function setUp()
    {
        $this->mock = new MongoMockup();
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
        $data = new VisitorMapper($this->mock->getConfig());

        // checking instance object return
        $this->assertInstanceOf('\MongoId', $data->add(['test' => 'test']));
    }
}