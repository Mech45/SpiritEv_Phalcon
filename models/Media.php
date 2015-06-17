<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class Media extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $evenement_id;

    /**
     *
     * @var integer
     */
    public $profile_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $path;

    /**
     *
     * @var string
     */
    public $date_import;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
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
