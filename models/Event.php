<?php

namespace PhalconRest\Models;

use DateTime;
use PhalconRest\Exceptions\HTTPException;

class Event extends \Phalcon\Mvc\Model {

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $date_create;

    /**
     *
     * @var string
     */
    protected $date_update;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $location;

    /**
     *
     * @var integer
     */
    protected $actif;

    /**
     *
     * @var string
     */
    protected $hour_begin;

    /**
     *
     * @var string
     */
    protected $hour_end;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field date_create
     *
     * @param string $date_create
     * @return $this
     */
    public function setDateCreate($date_create) {
        $this->date_create = $date_create;

        return $this;
    }

    /**
     * Method to set the value of field date_update
     *
     * @param string $date_update
     * @return $this
     */
    public function setDateUpdate($date_update) {
        $this->date_update = $date_update;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        //The name is too short?
        if (strlen($name) < 1) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Le nom doit comporter au moins 1 char',
        'internalCode' => 'SpiritErrorProfilSetName',
        'more' => 'there is no more here sorry'
            )
            );
        }
//        if (!preg_match("#^\p{L}+$#u",$name)) {
//            throw new HTTPException(
//                'Bad Request',
//                400,
//                array(
//                    'dev' => 'Caracteres numériques interdit',
//                    'internalCode' => 'SpiritErrorProfilSetName',
//                    'more' => '$name == ' . $name
//                )
//            );
//        }
        $this->name = $name;
    }

    /**
     * Method to set the value of field location
     *
     * @param string $location
     * @return $this
     */
    public function setLocation($location) {
        $this->location = $location;

        return $this;
    }

    /**
     * Method to set the value of field actif
     *
     * @param integer $actif
     * @return $this
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Method to set the value of field hour_begin
     *
     * @param string $hour_begin
     * @return $this
     */
    public function setHourBegin($hour_begin) {
        if (!$this->validateMySqlDate($hour_begin, "Y-m-d H:i:s")) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'format de date incorrecte',
        'internalCode' => 'SpiritErrorProfilSetBirthday',
        'more' => 'there is no more here sorry'
            )
            );
        } else if (strtotime($hour_begin) <= strtotime('now')) {
            throw new HTTPException(
            'Bad Request', 400, array(
        'dev' => 'Vous avez saisie une date passée',
        'internalCode' => 'SpiritErrorEventSetHourBegin',
        'more' => strtotime($hour_begin) . " < " . strtotime('now')
            )
            );
        }
        $this->hour_begin = $hour_begin;

        return $this;
    }

    /**
     * Method to set the value of field hour_end
     *
     * @param string $hour_end
     * @return $this
     */
    public function setHourEnd($hour_end) {
        if (!$this->validateMySqlDate($hour_end, "Y-m-d H:i:s")) {
            throw new HTTPException(
                'Bad Request', 400, array(
                    'dev' => 'format de date incorrecte',
                    'internalCode' => 'SpiritErrorProfilSetBirthday',
                    'more' => 'there is no more here sorry'
                )
            );
        } else if (strtotime($hour_end) <= strtotime('now')) {
            throw new HTTPException(
                'Bad Request', 400, array(
                'dev' => 'Vous avez saisi une date passée',
                'internalCode' => 'SpiritErrorEventSetHourBegin',
                'more' => strtotime($hour_end) . " < " . strtotime('now')
                )
            );
        }

        $this->hour_end = $hour_end;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the value of field date_create
     *
     * @return string
     */
    public function getDateCreate() {
        return $this->date_create;
    }

    /**
     * Returns the value of field date_update
     *
     * @return string
     */
    public function getDateUpdate() {
        return $this->date_update;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the value of field location
     *
     * @return string
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * Returns the value of field actif
     *
     * @return integer
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Returns the value of field hour_begin
     *
     * @return string
     */
    public function getHourBegin() {
        return $this->hour_begin;
    }

    /**
     * Returns the value of field hour_end
     *
     * @return string
     */
    public function getHourEnd() {
        return $this->hour_end;
    }

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->hasMany('id', 'Checklist', 'event_id', array('alias' => 'Checklist'));
        $this->hasMany('id', 'Comment', 'event_id', array('alias' => 'Comment'));
        $this->hasMany('id', 'EventHasRight', 'event_id', array('alias' => 'EventHasRight'));
        $this->hasMany('id', 'Invitation', 'event_id', array('alias' => 'Invitation'));
        $this->hasMany('id', 'Media', 'evenement_id', array('alias' => 'Media'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'event';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event[]
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    private function validateMySqlDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
