<?php
namespace Octopussy\Models;

/**
 * Session class. Session hash storage model
 *
 * @package Octopussy
 * @subpackage Octopussy\Models
 * @since PHP >=5.5
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Octopussy/Models/Session.php
 */
class Session {

    /**
     * Collection name
     *
     * @const COLLECTION
     */
    const COLLECTION = 'session';

    /**
     * User id
     *
     * @var string $id
     */
    private $id;

    /**
     * Hash data
     *
     * @var string $hash
     */
    private $hash;

    /**
     * Get user id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user id
     *
     * @param string $id
     * @return Session
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get user hash
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get user data hash
     *
     * @param string $hash
     * @return Session
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }

    /**
     * Initialize model & validate session data
     *
     * @param array $data
     */
    public function __construct(array $data) {

        // validate client data
        $this->setId($data['id'])->setHash($data['hash']);
    }

    /**
     * Get properties as array view
     *
     * @return array
     */
    public function toArray() {

        foreach($properties = get_object_vars($this) as $var => &$value) {
            if(gettype($value)  === 'object') {
                unset($properties[$var]);
            }
        }

        return $properties;
    }
}