<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class UserChecklistRessource extends \Phalcon\Mvc\Model
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
    public $user_id;

    /**
     *
     * @var integer
     */
    public $checklist_ressource_id;

    /**
     *
     * @var integer
     */
    public $quantity;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
        $this->belongsTo('checklist_ressource_id', 'ChecklistRessource', 'id', array('alias' => 'ChecklistRessource'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_checklist_ressource';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserChecklistRessource[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserChecklistRessource
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
