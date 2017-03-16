<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reorder")
 */
class ReorderEntity
{

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\ProductEntity")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $reorderedDate;

    /**
     * @ORM\Column(name="expectedDelivery", type="datetime")
     */
    private $expectedDeliveryDate;

    /**
     * @ORM\Column(name="deliveredDate", type="datetime", nullable=TRUE)
     */
    private $deliveredDate;

    public static function instance(): ReorderEntity
    {
        return new ReorderEntity();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): ReorderEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ProductEntity
     */
    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(ProductEntity $product): ReorderEntity
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): ReorderEntity
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getReorderedDate()
    {
        return $this->reorderedDate;
    }

    public function setReorderedDate($reorderedDate): ReorderEntity
    {
        $this->reorderedDate = $reorderedDate;
        return $this;
    }

    public function getExpectedDeliveryDate()
    {
        return $this->expectedDeliveryDate;
    }

    public function setExpectedDeliveryDate($expectedDeliveryDate): ReorderEntity
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;
        return $this;
    }

    public function getDeliveredDate()
    {
        return $this->deliveredDate;
    }

    public function setDeliveredDate($deliveredDate): ReorderEntity
    {
        $this->deliveredDate = $deliveredDate;
        return $this;
    }

}