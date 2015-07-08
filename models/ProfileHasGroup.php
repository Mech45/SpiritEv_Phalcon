<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ProfileHasGroup extends \Phalcon\Mvc\Model
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
    protected $group_profile_id;

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
     * Method to set the value of field group_profile_id
     *
     * @param integer $group_profile_id
     * @return $this
     */
    public function setGroupProfileId($group_profile_id)
    {
        $this->group_profile_id = $group_profile_id;

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
     * Returns the value of field group_profile_id
     *
     * @return integer
     */
    public function getGroupProfileId()
    {
        return $this->group_profile_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('group_profile_id', 'GroupProfile', 'id', array('alias' => 'GroupProfile'));
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'profile_has_group';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasGroup[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasGroup
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
