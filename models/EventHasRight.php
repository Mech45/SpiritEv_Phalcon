<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class EventHasRight extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $event_id;

    /**
     *
     * @var integer
     */
    protected $right_event_id;

    /**
     *
     * @var integer
     */
    protected $user_id;

    /**
     * Method to set the value of field event_id
     *
     * @param integer $event_id
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->event_id = $event_id;

        return $this;
    }

    /**
     * Method to set the value of field right_event_id
     *
     * @param integer $right_event_id
     * @return $this
     */
    public function setRightEventId($right_event_id)
    {
        $this->right_event_id = $right_event_id;

        return $this;
    }

    /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Returns the value of field event_id
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Returns the value of field right_event_id
     *
     * @return integer
     */
    public function getRightEventId()
    {
        return $this->right_event_id;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
        $this->belongsTo('right_event_id', 'RightEvent', 'id', array('alias' => 'RightEvent'));
        $this->belongsTo('event_id', 'Event', 'id', array('alias' => 'Event'));
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
