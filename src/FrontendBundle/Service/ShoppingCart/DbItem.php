<?php

namespace FrontendBundle\Service\ShoppingCart;

use CoreBundle\Entity\ProductEntity;

class DbItem implements Item
{

    private $productEntity;
    private $quantity = 1;
    private $image;

    public function __construct(ProductEntity $productEntity)
    {
        $this->productEntity = $productEntity;
        $this->image = base64_encode(stream_get_contents($this->productEntity->getImage()->getBinary()));
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getId()
    {
        return $this->productEntity->getId();
    }

    public function getName()
    {
        return $this->productEntity->getName();
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getPrice()
    {
        return $this->productEntity->getPrice();
    }

    public function getSum()
    {
        return $this->getPrice() * $this->getQuantity();
    }

    public function getJsonData()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'quantity' => $this->getQuantity(),
            'sum' => $this->getSum(),
            'image' => 'data:image/png;base64,' . $this->getImage()
        ];
    }

}