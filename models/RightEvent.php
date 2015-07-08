<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class RightEvent extends \Phalcon\Mvc\Model
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
    protected $indice;

    /**
     *
     * @var string
     */
    protected $statut;

    /**
     *
     * @var string
     */
    protected $description;

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
     * Method to set the value of field indice
     *
     * @param integer $indice
     * @return $this
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Method to set the value of field statut
     *
     * @param string $statut
     * @return $this
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Returns the value of field indice
     *
     * @return integer
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Returns the value of field statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'EventHasRight', 'right_event_id', array('alias' => 'EventHasRight'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'right_event';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RightEvent[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RightEvent
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
