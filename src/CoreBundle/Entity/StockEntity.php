<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class StockEntity
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\ProductEntity")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(name="inventoryDate", type="datetime", nullable=FALSE)
     */
    private $inventoryDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public static function instance(): StockEntity
    {
        return new StockEntity();
    }

    public function changeQuantity($quantity): StockEntity
    {
        $this->quantity = $this->quantity + $quantity;
        return $this;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    public function setProduct(ProductEntity $product): StockEntity
    {
        $this->product = $product;
        return $this;
    }

    public function getInventoryDate()
    {
        return $this->inventoryDate;
    }

    public function setInventoryDate($inventoryDate): StockEntity
    {
        $this->inventoryDate = $inventoryDate;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): StockEntity
    {
        $this->quantity = $quantity;
        return $this;
    }

}