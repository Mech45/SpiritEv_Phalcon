<?php

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

}
