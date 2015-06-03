<?php

namespace PhalconRest\Models;
use Phalcon\Mvc\Model;

class Profile extends Model
{
    public $id;
    public $name;
    public $firstname;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        if (!ctype_alpha($name)) {
            throw new \InvalidArgumentException("Caracteres numériques interdit");
        }
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setFirstname($firstname)
    {
        if (!ctype_alpha($firstname)) {
            throw new \InvalidArgumentException("Caracteres numériques interdit");
        }
        $this->firstname = $firstname;
    }
    
}

