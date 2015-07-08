<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ChecklistRessource extends \Phalcon\Mvc\Model
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
    protected $checklist_id;

    /**
     *
     * @var integer
     */
    protected $ressource_id;

    /**
     *
     * @var integer
     */
    protected $quantity;

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
     * Method to set the value of field checklist_id
     *
     * @param integer $checklist_id
     * @return $this
     */
    public function setChecklistId($checklist_id)
    {
        $this->checklist_id = $checklist_id;

        return $this;
    }

    /**
     * Method to set the value of field ressource_id
     *
     * @param integer $ressource_id
     * @return $this
     */
    public function setRessourceId($ressource_id)
    {
        $this->ressource_id = $ressource_id;

        return $this;
    }

    /**
     * Method to set the value of field quantity
     *
     * @param integer $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * Returns the value of field checklist_id
     *
     * @return integer
     */
    public function getChecklistId()
    {
        return $this->checklist_id;
    }

    /**
     * Returns the value of field ressource_id
     *
     * @return integer
     */
    public function getRessourceId()
    {
        return $this->ressource_id;
    }

    /**
     * Returns the value of field quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'UserChecklistRessource', 'checklist_ressource_id', array('alias' => 'UserChecklistRessource'));
        $this->belongsTo('ressource_id', 'Ressource', 'id', array('alias' => 'Ressource'));
        $this->belongsTo('checklist_id', 'Checklist', 'id', array('alias' => 'Checklist'));
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
