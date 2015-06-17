<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ChecklistRessource extends \Phalcon\Mvc\Model
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
    public $checklist_id;

    /**
     *
     * @var integer
     */
    public $ressource_id;

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
        $this->hasMany('id', 'UserChecklistRessource', 'checklist_ressource_id', array('alias' => 'UserChecklistRessource'));
        $this->belongsTo('checklist_id', 'Checklist', 'id', array('alias' => 'Checklist'));
        $this->belongsTo('ressource_id', 'Ressource', 'id', array('alias' => 'Ressource'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'checklist_ressource';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ChecklistRessource[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ChecklistRessource
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
