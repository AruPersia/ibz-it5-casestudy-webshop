<?php

namespace CoreBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;

class AddressData implements \Serializable
{

    /**
     * @Assert\NotBlank()
     */
    private $street;

    /**
     * @Assert\NotBlank()
     */
    private $houseNumber;

    /**
     * @Assert\NotBlank()
     */
    private $postCode;

    /**
     * @Assert\NotBlank()
     */
    private $city;

    public static function builder()
    {
        return new AddressData();
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street): AddressData
    {
        $this->street = $street;
        return $this;
    }

    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    public function setHouseNumber($houseNumber): AddressData
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function setPostCode($postCode): AddressData
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): AddressData
    {
        $this->city = $city;
        return $this;
    }

    public function serialize()
    {
        return join(';', [$this->street, $this->houseNumber, $this->postCode, $this->city]);
    }

    public function unserialize($serialized)
    {
        $data = explode(';', $serialized);
        $this->street = $data[0];
        $this->houseNumber = $data[1];
        $this->postCode = $data[2];
        $this->city = $data[3];
    }


}