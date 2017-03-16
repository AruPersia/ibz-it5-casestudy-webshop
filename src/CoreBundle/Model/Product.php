<?php

namespace CoreBundle\Model;

use CoreBundle\Util\ValidateUtil;

class Product
{

    private $id;
    private $name;
    private $description;
    private $price;
    private $stockQuantity;
    private $enabled;
    private $category;
    private $image;
    private $images;

    public function __construct($id, $name, $description, $price, $stockQuantity, $enabled, Category $category, Image $image, $images = array())
    {
        ValidateUtil::notNulls($name, $description, $price, $stockQuantity, $enabled, $category, $image);

        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->enabled = $enabled;
        $this->category = $category;
        $this->image = $image;
        $this->images = $images;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    function __toString()
    {
        return sprintf('{%s {%d, %s, %s, %d}}', __CLASS__, $this->id, $this->name, $this->description, $this->price);
    }


}