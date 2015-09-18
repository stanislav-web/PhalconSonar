<?php
namespace Octopussy\Mappers\Db\Mongo;

use Octopussy\Aware\AbstractMongoMapper;
use Octopussy\Models\Session;
use Octopussy\Exceptions\SessionMapperException;

/**
 * SessionMapper class. Mongo DB Mapper
 *
 * @package Octopussy
 * @subpackage Octopussy\Mappers\Db
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Mappers/Db/SessionMapper.php
 */
class SessionMapper extends AbstractMongoMapper {

    /**
     * Using collection
     *
     * @const COLLECTION
     */
    const COLLECTION = Session::COLLECTION;

    /**
     * Add records to collection
     *
     * @param array $data
     * @throws \Octopussy\Exceptions\SessionMapperException
     * @return \MongoId
     */
    public function add(array $data) {

        try {
            $document = (new Session($data))->toArray();
            $this->collection->insert($document, ['w' => true]);

            return new \MongoId($document['_id']);
        }
        catch(\MongoCursorException $e) {
            throw new SessionMapperException($e->getMessage());
        }
        catch (\MongoException $e ) {
            throw new SessionMapperException($e->getMessage());
        }
    }

    /**
     * Remove records from collection
     *
     * @param array $criteria
     * @throws \Octopussy\Exceptions\SessionMapperException
     */
    public function remove(array $criteria) {}
}