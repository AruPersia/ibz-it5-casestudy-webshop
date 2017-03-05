<?php

namespace BackendBundle\Form;

use CoreBundle\Form\PasswordData;
use Symfony\Component\Validator\Constraints as Assert;

class AdministratorData
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
     * @Assert\Valid()
     */
    private $passwordData;

    public static function builder(): AdministratorData
    {
        return new AdministratorData();
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): AdministratorData
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): AdministratorData
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): AdministratorData
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return PasswordData|null
     */
    public function getPasswordData()
    {
        return $this->passwordData;
    }

    public function setPasswordData(PasswordData $passwordData): AdministratorData
    {
        $this->passwordData = $passwordData;
        return $this;
    }

}

