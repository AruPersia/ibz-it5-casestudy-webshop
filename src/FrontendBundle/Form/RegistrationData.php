<?php

namespace FrontendBundle\Form;

use CoreBundle\Form\AddressData;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationData
{

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

    /**
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @Assert\Valid()
     */
    private $addressData;

    public static function builder()
    {
        return new RegistrationData();
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

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return AddressData|null
     */
    public function getAddressData()
    {
        return $this->addressData;
    }

    public function setAddressData(AddressData $addressData = null)
    {
        $this->addressData = $addressData;
    }

}