<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class Event extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $date_create;

    /**
     *
     * @var string
     */
    public $date_update;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $location;

    /**
     *
     * @var integer
     */
    public $actif;

    /**
     *
     * @var string
     */
    public $hour_begin;

    /**
     *
     * @var string
     */
    public $hour_end;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Checklist', 'event_id', array('alias' => 'Checklist'));
        $this->hasMany('id', 'Comment', 'event_id', array('alias' => 'Comment'));
        $this->hasMany('id', 'EventHasRight', 'event_id', array('alias' => 'EventHasRight'));
        $this->hasMany('id', 'Media', 'evenement_id', array('alias' => 'Media'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'event';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
