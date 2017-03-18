<?php

namespace CoreBundle\Model;

class Administrator
{

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $roles;

    public function __construct($id, $firstName, $lastName, $email, $roles = array())
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->roles = $roles;
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

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return String[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

}