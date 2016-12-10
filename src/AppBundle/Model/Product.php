<?php

namespace AppBundle\Model;

class Product
{

    private $id;
    private $name;
    private $image;

    public function __construct($id, $name, Image $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

}