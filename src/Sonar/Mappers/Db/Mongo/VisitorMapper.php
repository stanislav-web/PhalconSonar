<?php
namespace Sonar\Mappers\Db\Mongo;

use Sonar\Aware\AbstractMongoMapper;
use Sonar\Models\Visitor;
use Sonar\Exceptions\MongoMapperException;

/**
 * Class VisitorMapper. Mongo DB Mapper
 *
 * @package Sonar\Mappers\Db\Mongo
 * @subpackage Sonar\Mappers\Db
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Sonar/Mappers/Db/Mongo/VisitorMapper.php
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
     * @throws \Sonar\Exceptions\MongoMapperException
     * @return \MongoId
     */
    public function add(array $data) {

        try {
            $document = (new Visitor($data))->toArray();
            $this->collection->insert($document, ['w' => true]);

            return new \MongoId($document['_id']);
        }
        catch (\MongoCursorException $e) {
            throw new MongoMapperException($e->getMessage());
        }
        catch (\MongoException $e) {
            throw new MongoMapperException($e->getMessage());
        }
    }

    /**
     * Remove records from collection
     *
     * @param array $criteria
     * @throws \Sonar\Exceptions\MongoMapperException
     */
    public function remove(array $criteria) {}
}