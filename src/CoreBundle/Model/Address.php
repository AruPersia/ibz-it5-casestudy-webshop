<?php

namespace CoreBundle\Model;

class Address
{

    private $id;
    private $street;
    private $houseNumber;
    private $postCode;
    private $city;

    public function __construct($id, $street, $houseNumber, $postCode, $city)
    {
        $this->id = $id;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->postCode = $postCode;
        $this->city = $city;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function getCity()
    {
        return $this->city;
    }

}