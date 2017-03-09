<?php

namespace BackendBundle\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProductData
{

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
     * @Assert\Type(type="array")
     */
    private $images;

    public static function instance(): ProductData
    {
        return new ProductData();
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

    /**
     * @return UploadedFile[]
     */
    public function getImages()
    {
        return $this->images;
    }

    public function setImages($images): ProductData
    {
        $this->images = $images;
        return $this;
    }

}

