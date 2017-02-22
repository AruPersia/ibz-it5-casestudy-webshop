<?php

namespace CoreBundle\Model;

class CustomerBuilder
{

    private $id;
    private $firstName;
    private $lastName;
    private $email;

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

    public function build(): Customer
    {
        return new Customer($this->id, $this->firstName, $this->lastName, $this->email);
    }

}