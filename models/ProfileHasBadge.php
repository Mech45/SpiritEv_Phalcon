<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ProfileHasBadge extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $profile_id;

    /**
     *
     * @var integer
     */
    protected $badge_id;

    /**
     * Method to set the value of field profile_id
     *
     * @param integer $profile_id
     * @return $this
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;

        return $this;
    }

    /**
     * Method to set the value of field badge_id
     *
     * @param integer $badge_id
     * @return $this
     */
    public function setBadgeId($badge_id)
    {
        $this->badge_id = $badge_id;

        return $this;
    }

    /**
     * Returns the value of field profile_id
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * Returns the value of field badge_id
     *
     * @return integer
     */
    public function getBadgeId()
    {
        return $this->badge_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('badge_id', 'Badge', 'id', array('alias' => 'Badge'));
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
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
