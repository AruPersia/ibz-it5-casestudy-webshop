<?php

namespace CoreBundle\Model;

class AddressBuilder implements Builder
{

    private $id;
    private $street;
    private $houseNumber;
    private $postCode;
    private $city;

    private function __construct()
    {
        // private constructor
    }

    public static function instance(): AddressBuilder
    {
        return new AddressBuilder();
    }

    public function build(): Address
    {
        return new Address($this->id, $this->street, $this->houseNumber, $this->postCode, $this->city);
    }

    public function setId($id): AddressBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setStreet($street): AddressBuilder
    {
        $this->street = $street;
        return $this;
    }

    public function setHouseNumber($houseNumber): AddressBuilder
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    public function setPostCode($postCode): AddressBuilder
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function setCity($city): AddressBuilder
    {
        $this->city = $city;
        return $this;
    }

}