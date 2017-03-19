<?php

namespace CoreBundle\Model;

class Customer
{

    private $id;
    private $gender;
    private $firstName;
    private $lastName;
    private $email;
    private $address;

    public function __construct($id, $gender, $firstName, $lastName, $email, Address $address)
    {
        $this->id = $id;
        $this->gender = $gender;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->address = $address;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGender()
    {
        return $this->gender;
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

    public function getAddress(): Address
    {
        return $this->address;
    }

}