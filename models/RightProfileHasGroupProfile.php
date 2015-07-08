<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class RightProfileHasGroupProfile extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $right_profile_id;

    /**
     *
     * @var integer
     */
    protected $group_profile_id;

    /**
     * Method to set the value of field right_profile_id
     *
     * @param integer $right_profile_id
     * @return $this
     */
    public function setRightProfileId($right_profile_id)
    {
        $this->right_profile_id = $right_profile_id;

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
     * Returns the value of field right_profile_id
     *
     * @return integer
     */
    public function getRightProfileId()
    {
        return $this->right_profile_id;
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
        $this->belongsTo('right_profile_id', 'RightProfile', 'id', array('alias' => 'RightProfile'));
        $this->belongsTo('group_profile_id', 'GroupProfile', 'id', array('alias' => 'GroupProfile'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'right_profile_has_group_profile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RightProfileHasGroupProfile[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RightProfileHasGroupProfile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
