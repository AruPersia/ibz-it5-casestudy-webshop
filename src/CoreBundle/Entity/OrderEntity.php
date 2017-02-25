<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`order`")
 */
class OrderEntity implements EntityBuilder
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="oderDate", type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(name="shipmentDate", type="datetime")
     */
    private $shipmentDate;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\CustomerEntity", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(name="customerId", referencedColumnName="id", nullable=FALSE)
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\OrderLineEntity", mappedBy="order", cascade={"persist"}, fetch="EAGER")
     */
    private $orderLines;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }

    public static function instance(): OrderEntity
    {
        return new OrderEntity();
    }

    public function addLine(ProductEntity $productEntity, $quantity): OrderEntity
    {
        $this->orderLines->add(OrderLineEntity::instance()
            ->setOrder($this)
            ->setProduct($productEntity)
            ->setPrice($productEntity->getPrice())
            ->setQuantity($quantity));

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): OrderEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate): OrderEntity
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function getShipmentDate()
    {
        return $this->shipmentDate;
    }

    public function setShipmentDate($shipmentDate): OrderEntity
    {
        $this->shipmentDate = $shipmentDate;
        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer): OrderEntity
    {
        $this->customer = $customer;
        return $this;
    }

    public function getOrderLines()
    {
        return $this->orderLines;
    }

}