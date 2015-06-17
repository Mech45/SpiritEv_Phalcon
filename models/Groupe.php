<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class Groupe extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'ProfileHasGroupe', 'groupe_id', array('alias' => 'ProfileHasGroupe'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'groupe';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupe[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Groupe
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
