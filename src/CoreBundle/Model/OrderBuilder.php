<?php

namespace CoreBundle\Model;

class OrderBuilder
{

    private $id;
    private $orderDate;
    private $shipmentDate;
    private $customer;
    private $orderLines;

    private function __construct()
    {
        // Keep private
        $this->orderLines = array();
    }

    public static function instance(): OrderBuilder
    {
        return new OrderBuilder();
    }

    public function setId($id): OrderBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setOrderDate($orderDate): OrderBuilder
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function setShipmentDate($shipmentDate): OrderBuilder
    {
        $this->shipmentDate = $shipmentDate;
        return $this;
    }

    public function setCustomer(Customer $customer): OrderBuilder
    {
        $this->customer = $customer;
        return $this;
    }

    public function setOrderLines($orderLines = array()): OrderBuilder
    {
        $this->orderLines = $orderLines;
        return $this;
    }

    public function addOrderLine(OrderLine $orderLine): OrderBuilder
    {
        $this->orderLines[] = $orderLine;
        return $this;
    }

    public function build(): Order
    {
        return new Order($this->id, $this->orderDate, $this->shipmentDate, $this->customer, $this->orderLines);
    }

}