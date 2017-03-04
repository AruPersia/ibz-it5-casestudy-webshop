<?php

namespace CoreBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class PersonalData implements \Serializable
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

    public static function builder(): PersonalData
    {
        return new PersonalData();
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): PersonalData
    {
        $this->gender = $gender;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): PersonalData
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): PersonalData
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): PersonalData
    {
        $this->email = $email;
        return $this;
    }

    public function serialize()
    {
        return join(';', [$this->gender, $this->firstName, $this->lastName, $this->email]);
    }

    public function unserialize($serialized)
    {
        $data = explode(';', $serialized);
        $this->gender = $data[0];
        $this->firstName = $data[1];
        $this->lastName = $data[2];
        $this->email = $data[3];
    }


}