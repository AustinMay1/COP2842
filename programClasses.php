<?php

class Instructor {
    private $id;
    private $firstName;
    private $lastName;

    public function __construct($id, $firstName, $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
    
    public function setFirstName($firstName) 
    {
        if($firstName) 
        {
            $this->firstName = $firstName;
        }
    }

    public function setLastName($lastName)
    {
        if($lastName)
        {
            $this->lastName = $lastName;
        }
    }

    public function getId() 
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        $fullName = $this->firstName . " " . $this->lastName;
        return $fullName;
    }
}


?>