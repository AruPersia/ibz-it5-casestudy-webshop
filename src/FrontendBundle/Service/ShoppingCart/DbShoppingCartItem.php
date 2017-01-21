<?php

namespace FrontendBundle\Service\ShoppingCart;

use CoreBundle\Entity\ProductEntity;
use Symfony\Component\Intl\Exception\MethodNotImplementedException;

class DbShoppingCartItem implements ShoppingCartItem
{

    private $productEntity;
    private $quantity = 1;

    public function __construct(ProductEntity $productEntity)
    {
        $this->productEntity = $productEntity;
    }

    public function getImage()
    {
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function getJsonData()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'quantity' => $this->getQuantity(),
            'sum' => $this->getSum()
        ];
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

    public function getSum()
    {
        return $this->getPrice() * $this->getQuantity();
    }

    public function getPrice()
    {
        return $this->productEntity->getPrice();
    }


}