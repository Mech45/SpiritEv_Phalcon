<?php
namespace PhalconRest\Models;

use DateTime;
use PhalconRest\Exceptions\HTTPException;

class Profile extends \Phalcon\Mvc\Model
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
    protected $language_id;

    /**
     *
     * @var integer
     */
    protected $civility_id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $firstname;

    /**
     *
     * @var string
     */
    protected $birthday;

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
     * Method to set the value of field language_id
     *
     * @param integer $language_id
     * @return $this
     */
    public function setLanguageId($language_id)
    {
        $this->language_id = $language_id;

        return $this;
    }

    /**
     * Method to set the value of field civility_id
     *
     * @param integer $civility_id
     * @return $this
     */
    public function setCivilityId($civility_id)
    {
        $this->civility_id = $civility_id;

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
     * Returns the value of field language_id
     *
     * @return integer
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * Returns the value of field civility_id
     *
     * @return integer
     */
    public function getCivilityId()
    {
        return $this->civility_id;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Returns the value of field birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Invitation', 'profile_id', array('alias' => 'Invitation'));
        $this->hasMany('id', 'Media', 'profile_id', array('alias' => 'Media'));
        $this->hasMany('id', 'ProfileHasBadge', 'profile_id', array('alias' => 'ProfileHasBadge'));
        $this->hasMany('id', 'ProfileHasGroup', 'profile_id', array('alias' => 'ProfileHasGroup'));
        $this->hasMany('id', 'ProfileHasProfile', 'profile_id', array('alias' => 'ProfileHasProfile'));
        $this->hasMany('id', 'ProfileHasProfile', 'profile_friend_id1', array('alias' => 'ProfileHasProfile'));
        $this->hasMany('id', 'User', 'profile_id', array('alias' => 'User'));
        $this->belongsTo('civility_id', 'Civility', 'id', array('alias' => 'Civility'));
        $this->belongsTo('language_id', 'Language', 'id', array('alias' => 'Language'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'profile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasProfile[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProfileHasProfile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

        /*
     * permet de setter le nom
     * @return void
     */
    public function setName($name)
    {
        //The name is too short?
        if (strlen($name) < 1) {
            throw new HTTPException(
                'Bad Request',
                400,
                array(
                    'dev' => 'Le nom doit comporter au moins 1 char',
                    'internalCode' => 'SpiritErrorProfilSetName',
                    'more' => 'there is no more here sorry'
                )
            );
        }
        if (!preg_match("#^\p{L}+$#u",$name)) {
            throw new HTTPException(
                'Bad Request',
                400,
                array(
                    'dev' => 'Caracteres numériques interdit',
                    'internalCode' => 'SpiritErrorProfilSetName',
                    'more' => '$name == ' . $name
                )
            );
        }
        $this->name = $name;
    }
    
    /*
     * permet de setter le prenom
     * @return void
     */
    public function setFirstname($firstname)
    {
        //The firstname is too short?
        if (strlen($firstname) < 1) {
            throw new HTTPException(
                'Bad Request',
                400,
                array(
                    'dev' => 'Le prénom doit comporter au moins 1 char',
                    'internalCode' => 'SpiritErrorProfilSetFirstName',
                    'more' => 'there is no more here sorry'
                )
            );
        }
        if (!preg_match("#^\p{L}+$#u", $firstname)) {
            throw new HTTPException(
                'Bad Request',
                400,
                array(
                    'dev' => 'Caracteres numériques interdit',
                    'internalCode' => 'SpiritErrorProfilSetFirstName',
                    'more' => '$firstname == ' . $firstname
                )
            );
        }
        $this->firstname = $firstname;
    }
    
    /*
     * Je considère que la date est un DATE au format MySql
     * met a jour la fate de naissance
     * @retun void
     */
    public function setBirthday($birthday)
    {
        if (!$this->validateMySqlDate($birthday)) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'format de date incorrecte',
                    'internalCode' => 'SpiritErrorProfilSetBirthday',
                    'more' => 'there is no more here sorry'
                )
            );
        } else if (strtotime($birthday) >= strtotime('now')) {
            throw new HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'Vous avez saisie la date du jour !',
                    'internalCode' => 'SpiritErrorProfilSetBirthday',
                    'more' => strtotime($birthday) . " >= " . strtotime('now')
                )
            );
        }
        $this->birthday = $birthday;
    }
    
    private function validateMySqlDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}
