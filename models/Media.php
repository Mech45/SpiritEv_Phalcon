<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class Media extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $evenement_id;

    /**
     *
     * @var integer
     */
    protected $profile_id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $path;

    /**
     *
     * @var string
     */
    protected $date_import;

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
     * Method to set the value of field evenement_id
     *
     * @param integer $evenement_id
     * @return $this
     */
    public function setEvenementId($evenement_id)
    {
        $this->evenement_id = $evenement_id;

        return $this;
    }

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
     * Method to set the value of field path
     *
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Method to set the value of field date_import
     *
     * @param string $date_import
     * @return $this
     */
    public function setDateImport($date_import)
    {
        $this->date_import = $date_import;

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
     * Returns the value of field evenement_id
     *
     * @return integer
     */
    public function getEvenementId()
    {
        return $this->evenement_id;
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
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns the value of field date_import
     *
     * @return string
     */
    public function getDateImport()
    {
        return $this->date_import;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'GroupProfile', 'media_id', array('alias' => 'GroupProfile'));
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
        $this->belongsTo('evenement_id', 'Event', 'id', array('alias' => 'Event'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'media';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Media[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Media
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
