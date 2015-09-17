<?php
namespace Octopussy\Mappers\Mongo;

use Octopussy\Aware\AbstractMapperBase;
use Octopussy\Models\Visitor;
use Octopussy\Exceptions\VisitorMapperException;

/**
 * VisitorMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/VisitorMapper.php
 */
class VisitorMapper extends AbstractMapperBase {

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
        catch(\MongoCursorException $e) {
            throw new VisitorMapperException($e->getMessage());
        }
        catch (\MongoException $e ) {
            throw new VisitorMapperException($e->getMessage());
        }
    }

    /**
     * Remove records from collection
     *
     * @param array $criteria
     * @throws \Octopussy\Exceptions\VisitorMapperException
     */
    public function remove(array $criteria) {

        try {
            $document = (new Visitor($criteria))->toArray();

            if(isset($document['_id']) === true) {
                $document['_id'] = new \MongoId($document['_id']);
            }

            $this->collection->insert($document, ['w' => true]);

            echo 'Product inserted with ID: ' . $document['_id'] . "\n";

            exit;
        }
        catch(\MongoCursorException $e) {
            throw new VisitorMapperException($e->getMessage());
        }
        catch (\MongoException $e ) {
            throw new VisitorMapperException($e->getMessage());
        }
    }
}