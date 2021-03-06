<?php

namespace BackendBundle\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProductData
{

    private $id;

    /**
     * @Assert\NotBlank()
     */
    private $categoryPath;

    /**
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @Assert\NotBlank()
     */
    private $stockQuantity;

    /**
     * @Assert\Type(type="Array")
     */
    private $images;

    public static function instance(): ProductData
    {
        return new ProductData();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategoryPath()
    {
        return $this->categoryPath;
    }

    public function setCategoryPath($categoryPath): ProductData
    {
        $this->categoryPath = $categoryPath;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): ProductData
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): ProductData
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): ProductData
    {
        $this->price = $price;
        return $this;
    }

    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity($stockQuantity): ProductData
    {
        $this->stockQuantity = $stockQuantity;
        return $this;
    }

    /**
     * @return UploadedFile[]
     */
    public function getImages()
    {
        return $this->images == null ? null : array_filter($this->images);
    }

    public function setImages($images): ProductData
    {
        $this->images = $images;
        return $this;
    }

}

