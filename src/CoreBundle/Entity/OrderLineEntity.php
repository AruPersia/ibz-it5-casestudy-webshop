<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orderLine")
 */
class OrderLineEntity implements EntityBuilder
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\OrderEntity", inversedBy="orderLines", cascade={"persist"})
     * @ORM\JoinColumn(name="orderId", referencedColumnName="id", nullable=FALSE)
     */
    private $order;

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\ProductEntity")
     * @ORM\JoinColumn(name="productId", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    public static function instance(): OrderLineEntity
    {
        return new OrderLineEntity();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): OrderLineEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order): OrderLineEntity
    {
        $this->order = $order;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product): OrderLineEntity
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): OrderLineEntity
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): OrderLineEntity
    {
        $this->price = $price;
        return $this;
    }

}