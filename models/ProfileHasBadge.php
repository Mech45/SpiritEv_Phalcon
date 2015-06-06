<?php

class ProfileHasBadge extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $profile_id;

    /**
     *
     * @var integer
     */
    public $badge_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
        $this->belongsTo('badge_id', 'Badge', 'id', array('alias' => 'Badge'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'profile_has_badge';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasBadge[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasBadge
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
