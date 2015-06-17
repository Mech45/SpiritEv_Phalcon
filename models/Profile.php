<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException as HTTPException;
use \DateTime as DateTime;

class Profile extends \Phalcon\Mvc\Model
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
    public $language_id;

    /**
     *
     * @var integer
     */
    public $civility_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $firstname;

    /**
     *
     * @var string
     */
    public $birthday;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Media', 'profile_id', array('alias' => 'Media'));
        $this->hasMany('id', 'ProfileHasBadge', 'profile_id', array('alias' => 'ProfileHasBadge'));
        $this->hasMany('id', 'ProfileHasGroupe', 'profile_id', array('alias' => 'ProfileHasGroupe'));
        $this->hasMany('id', 'User', 'profile_id', array('alias' => 'User'));
        $this->belongsTo('civility_id', 'Civility', 'id', array('alias' => 'Civility'));
        $this->belongsTo('language_id', 'Language', 'id', array('alias' => 'Language'));
        $this->useDynamicUpdate(true);
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

    /*
     * permet de setter le nom
     * @return void
     */
    public function setName($name)
    {
        //The name is too short?
        if (strlen($name) < 1) {
            throw new \PhalconRest\Exceptions\HTTPException(
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
            throw new \PhalconRest\Exceptions\HTTPException(
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
            throw new \PhalconRest\Exceptions\HTTPException(
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
            throw new \PhalconRest\Exceptions\HTTPException(
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
            throw new \PhalconRest\Exceptions\HTTPException(
                'Bad Request',
                400,
                array (
                    'dev' => 'format de date incorrecte',
                    'internalCode' => 'SpiritErrorProfilSetBirthday',
                    'more' => 'there is no more here sorry'
                )
            );
        } else if (strtotime($birthday) >= strtotime('now')) {
            throw new \PhalconRest\Exceptions\HTTPException(
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
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Profile[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Profile
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    public function save($data = null, $whiteList = null)
    {
       parent::save($data, $whiteList);
    }

}
