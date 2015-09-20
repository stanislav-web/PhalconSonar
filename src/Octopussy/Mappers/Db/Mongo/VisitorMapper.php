<?php
namespace Octopussy\Mappers\Db\Mongo;

use Octopussy\Aware\AbstractMongoMapper;
use Octopussy\Models\Visitor;
use Octopussy\Exceptions\VisitorMapperException;

/**
 * VisitorMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers\Db
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/Db/VisitorMapper.php
 */
class VisitorMapper extends AbstractMongoMapper {

    /**
     * Using collection
     *
     * @const COLLECTION
     */
    const COLLECTION = Visitor::COLLECTION;

    /**
     * Add records to collection
     *
     * @param array $data
     * @throws \Octopussy\Exceptions\VisitorMapperException
     * @return \MongoId
     */
    public function add(array $data) {

        try {
            $document = (new Visitor($data))->toArray();
            $this->collection->insert($document, ['w' => true]);

            return new \MongoId($document['_id']);
        }
        catch (\MongoCursorException $e) {
            throw new VisitorMapperException($e->getMessage());
        }
        catch (\MongoException $e) {
            throw new VisitorMapperException($e->getMessage());
        }
    }

    /**
     * Remove records from collection
     *
     * @param array $criteria
     * @throws \Octopussy\Exceptions\VisitorMapperException
     */
    public function remove(array $criteria) {}
}