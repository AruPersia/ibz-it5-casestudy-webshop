<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock",
 *     indexes={
 *      @ORM\Index(name="productId_inventoryDate_idx", columns={"product_id", "inventory_date"})
 *     })
 */
class StockEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $productId;

    /**
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    private $inventoryDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getInventoryDate()
    {
        return $this->inventoryDate;
    }

    public function setInventoryDate($inventoryDate)
    {
        $this->inventoryDate = $inventoryDate;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

}