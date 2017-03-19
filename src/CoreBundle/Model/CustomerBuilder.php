<?php

namespace CoreBundle\Model;

class CustomerBuilder
{

    private $id;
    private $gender;
    private $firstName;
    private $lastName;
    private $email;
    private $address;

    private function __construct()
    {
        // Keep private
    }

    public static function instance(): CustomerBuilder
    {
        return new CustomerBuilder();
    }

    public function setId($id): CustomerBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setGender($gender): CustomerBuilder
    {
        $this->gender = $gender;
        return $this;
    }

    public function setFirstName($firstName): CustomerBuilder
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName): CustomerBuilder
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setEmail($email): CustomerBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function setAddress($address): CustomerBuilder
    {
        $this->address = $address;
        return $this;
    }

    public function build(): Customer
    {
        return new Customer($this->id, $this->gender, $this->firstName, $this->lastName, $this->email, $this->address);
    }

}