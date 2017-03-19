<?php

namespace FrontendBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class CustomerData
{

    /**
     * @Assert\NotBlank()
     */
    private $gender;

    /**
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    public static function builder()
    {
        return new CustomerData();
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

}