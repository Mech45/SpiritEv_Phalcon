<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class Right extends \Phalcon\Mvc\Model
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
    public $indice;

    /**
     *
     * @var string
     */
    public $statut;

    /**
     *
     * @var string
     */
    public $description;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'EventHasRight', 'right_id', array('alias' => 'EventHasRight'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'right';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Right[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Right
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
