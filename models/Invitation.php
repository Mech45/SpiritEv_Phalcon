<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;
use Phalcon\Mvc\Model\Validator\Email as Email;

class Invitation extends \Phalcon\Mvc\Model
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
    protected $profile_id;

    /**
     *
     * @var string
     */
    protected $guest_id;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $invitation_date;

    /**
     *
     * @var string
     */
    protected $relanch_invitation_date;

    /**
     *
     * @var string
     */
    protected $validation_invitation_date;

    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @var string
     */
    protected $token_expiration;

    /**
     *
     * @var integer
     */
    protected $event_id;
    
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
     * Method to set the value of field profile_id
     *
     * @param integer $profile_id
     * @return $this
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;

        return $this;
    }

    /**
     * Method to set the value of field guest_id
     *
     * @param string $guest_id
     * @return $this
     */
    public function setGuestId($guest_id)
    {
        $this->guest_id = $guest_id;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field invitation_date
     *
     * @param string $invitation_date
     * @return $this
     */
    public function setInvitationDate($invitation_date)
    {
        $this->invitation_date = $invitation_date;

        return $this;
    }

    /**
     * Method to set the value of field relanch_invitation_date
     *
     * @param string $relanch_invitation_date
     * @return $this
     */
    public function setRelanchInvitationDate($relanch_invitation_date)
    {
        $this->relanch_invitation_date = $relanch_invitation_date;

        return $this;
    }

    /**
     * Method to set the value of field validation_invitation_date
     *
     * @param string $validation_invitation_date
     * @return $this
     */
    public function setValidationInvitationDate($validation_invitation_date)
    {
        $this->validation_invitation_date = $validation_invitation_date;

        return $this;
    }

    /**
     * Method to set the value of field token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Method to set the value of field token_expiration
     *
     * @param string $token_expiration
     * @return $this
     */
    public function setTokenExpiration($token_expiration)
    {
        $this->token_expiration = $token_expiration;

        return $this;
    }
    
    /**
     * Method to set the value of field event_id
     *
     * @param integer $event_id
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->event_id = $event_id;

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
     * Returns the value of field profile_id
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * Returns the value of field guest_id
     *
     * @return string
     */
    public function getGuestId()
    {
        return $this->guest_id;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field invitation_date
     *
     * @return string
     */
    public function getInvitationDate()
    {
        return $this->invitation_date;
    }

    /**
     * Returns the value of field relanch_invitation_date
     *
     * @return string
     */
    public function getRelanchInvitationDate()
    {
        return $this->relanch_invitation_date;
    }

    /**
     * Returns the value of field validation_invitation_date
     *
     * @return string
     */
    public function getValidationInvitationDate()
    {
        return $this->validation_invitation_date;
    }

    /**
     * Returns the value of field token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Returns the value of field token_expiration
     *
     * @return string
     */
    public function getTokenExpiration()
    {
        return $this->token_expiration;
    }
    
    /**
     * Returns the value of field event_id
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
//        $this->validate(
//            new Email(
//                array(
//                    'field'    => 'email',
//                    'required' => true,
//                )
//            )
//        );
//
//        if ($this->validationHasFailed() == true) {
//            return false;
//        }

        return true;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('profile_id', 'Profile', 'id', array('alias' => 'Profile'));
        $this->belongsTo('event_id', 'Event', 'id', array('alias' => 'Event'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'invitation';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Invitation[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Invitation
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
