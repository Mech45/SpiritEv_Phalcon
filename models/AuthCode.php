<?php

class AuthCode extends \Phalcon\Mvc\Model
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
    public $client_id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var string
     */
    public $redirect_uri;

    /**
     *
     * @var integer
     */
    public $expires_at;

    /**
     *
     * @var string
     */
    public $scope;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('client_id', 'Client', 'id', array('alias' => 'Client'));
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'auth_code';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return AuthCode[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return AuthCode
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
