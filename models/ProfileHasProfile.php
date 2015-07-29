<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ProfileHasProfile extends \Phalcon\Mvc\Model
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
    protected $profile_friend_id;

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
     * Method to set the value of field profile_friend_id
     *
     * @param integer $profile_friend_id
     * @return $this
     */
    public function setProfileFriendId($profile_friend_id)
    {
        $this->profile_friend_id = $profile_friend_id;

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
     * Returns the value of field profile_friend_id
     *
     * @return integer
     */
    public function getProfileFriendId()
    {
        return $this->profile_friend_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
        $this->belongsTo('profile_friend_id', 'Profile', 'id', array('alias' => 'Profile'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'profile_has_profile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasProfile[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasProfile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
