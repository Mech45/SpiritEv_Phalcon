<?php

class EventHasRight extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $event_id;

    /**
     *
     * @var integer
     */
    public $right_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('right_id', 'Right', 'id', array('alias' => 'Right'));
        $this->belongsTo('event_id', 'Event', 'id', array('alias' => 'Event'));
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'event_has_right';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EventHasRight[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EventHasRight
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
