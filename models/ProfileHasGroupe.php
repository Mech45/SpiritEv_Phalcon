<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ProfileHasGroupe extends \Phalcon\Mvc\Model
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
    public $groupe_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('groupe_id', 'Groupe', 'id', array('alias' => 'Groupe'));
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'profile_has_groupe';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasGroupe[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasGroupe
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
