<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class GroupProfile extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var integer
     */
    protected $media_id;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field media_id
     *
     * @param integer $media_id
     * @return $this
     */
    public function setMediaId($media_id)
    {
        $this->media_id = $media_id;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field media_id
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->media_id;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ProfileHasGroup', 'group_profile_id', array('alias' => 'ProfileHasGroup'));
        $this->hasMany('id', 'RightProfileHasGroupProfile', 'group_profile_id', array('alias' => 'RightProfileHasGroupProfile'));
        $this->belongsTo('media_id', 'Media', 'id', array('alias' => 'Media'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'group_profile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupProfile[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GroupProfile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
