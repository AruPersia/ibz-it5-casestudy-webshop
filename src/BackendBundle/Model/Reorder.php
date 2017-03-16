<?php

namespace BackendBundle\Model;

class Reorder
{

    private $id;
    private $product;
    private $quantity;
    private $reorderedDate;
    private $expectedDeliveryDate;
    private $deliveredDate;

    public function __construct($id, $product, $quantity, $reorderedDate, $expectedDeliveryData, $deliveredDate)
    {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->reorderedDate = $reorderedDate;
        $this->expectedDeliveryDate = $expectedDeliveryData;
        $this->deliveredDate = $deliveredDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getReorderedDate()
    {
        return $this->reorderedDate;
    }

    public function getExpectedDeliveryDate()
    {
        return $this->expectedDeliveryDate;
    }

    public function getDeliveredDate()
    {
        return $this->deliveredDate;
    }

}