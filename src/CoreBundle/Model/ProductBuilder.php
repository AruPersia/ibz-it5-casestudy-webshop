<?php

namespace CoreBundle\Model;

class ProductBuilder implements Builder
{

    private $id;
    private $name;
    private $description;
    private $price;
    private $stockQuantity;
    private $enabled = true;
    private $category;
    private $image;
    private $images;

    private function __construct()
    {
        // private constructor
        $this->images = array();
    }

    public static function instance(): ProductBuilder
    {
        return new ProductBuilder();
    }

    public function build(): Product
    {
        return new Product($this->id, $this->name, $this->description, $this->price, $this->stockQuantity, $this->enabled, $this->category, $this->image, $this->images);
    }

    public function setId($id): ProductBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name): ProductBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description): ProductBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice($price): ProductBuilder
    {
        $this->price = $price;
        return $this;
    }

    public function setStockQuantity($stockQuantity): ProductBuilder
    {
        $this->stockQuantity = $stockQuantity;
        return $this;
    }

    public function setEnabled($enabled): ProductBuilder
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function setCategory(Category $category): ProductBuilder
    {
        $this->category = $category;
        return $this;
    }

    public function setImage(Image $image): ProductBuilder
    {
        $this->image = $image;
        return $this;
    }

    public function setImages($images): ProductBuilder
    {
        $this->images = $images;
        return $this;
    }

}