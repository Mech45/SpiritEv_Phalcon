<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
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
    public $profile_id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $username_canonical;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $email_canonical;

    /**
     *
     * @var integer
     */
    public $enabled;

    /**
     *
     * @var string
     */
    public $salt;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $last_login;

    /**
     *
     * @var integer
     */
    public $locked;

    /**
     *
     * @var integer
     */
    public $expired;

    /**
     *
     * @var string
     */
    public $expires_at;

    /**
     *
     * @var string
     */
    public $confirmation_token;

    /**
     *
     * @var string
     */
    public $password_requested_at;

    /**
     *
     * @var string
     */
    public $roles;

    /**
     *
     * @var integer
     */
    public $credentials_expired;

    /**
     *
     * @var string
     */
    public $credentials_expire_at;

    /**
     *
     * @var string
     */
    public $facebook_id;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'AccessToken', 'user_id', array('alias' => 'AccessToken'));
        $this->hasMany('id', 'AuthCode', 'user_id', array('alias' => 'AuthCode'));
        $this->hasMany('id', 'Comment', 'user_id', array('alias' => 'Comment'));
        $this->hasMany('id', 'EventHasRight', 'user_id', array('alias' => 'EventHasRight'));
        $this->hasMany('id', 'RefreshToken', 'user_id', array('alias' => 'RefreshToken'));
        $this->hasMany('id', 'UserChecklistRessource', 'user_id', array('alias' => 'UserChecklistRessource'));
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
