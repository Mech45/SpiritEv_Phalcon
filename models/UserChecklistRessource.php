<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class UserChecklistRessource extends \Phalcon\Mvc\Model
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
    protected $user_id;

    /**
     *
     * @var integer
     */
    protected $checklist_ressource_id;

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
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field checklist_ressource_id
     *
     * @param integer $checklist_ressource_id
     * @return $this
     */
    public function setChecklistRessourceId($checklist_ressource_id)
    {
        $this->checklist_ressource_id = $checklist_ressource_id;

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
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field checklist_ressource_id
     *
     * @return integer
     */
    public function getChecklistRessourceId()
    {
        return $this->checklist_ressource_id;
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
        $this->belongsTo('checklist_ressource_id', 'ChecklistRessource', 'id', array('alias' => 'ChecklistRessource'));
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
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
