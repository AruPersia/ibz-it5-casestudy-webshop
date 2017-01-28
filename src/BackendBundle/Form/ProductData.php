<?php

namespace BackendBundle\Form;

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
    private $price;


    public function getCategoryPath()
    {
        return $this->categoryPath;
    }

    public function setCategoryPath($categoryPath)
    {
        $this->categoryPath = $categoryPath;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

}

