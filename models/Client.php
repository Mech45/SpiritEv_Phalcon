<?php

class Client extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $random_id;

    /**
     *
     * @var string
     */
    public $redirect_uris;

    /**
     *
     * @var string
     */
    public $secret;

    /**
     *
     * @var string
     */
    public $allowed_grant_types;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'AccessToken', 'client_id', array('alias' => 'AccessToken'));
        $this->hasMany('id', 'AuthCode', 'client_id', array('alias' => 'AuthCode'));
        $this->hasMany('id', 'RefreshToken', 'client_id', array('alias' => 'RefreshToken'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'client';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Client[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Client
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
