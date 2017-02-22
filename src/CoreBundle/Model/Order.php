<?php

namespace CoreBundle\Model;

class Order
{

    private $id;
    private $orderDate;
    private $shipmentDate;
    private $customer;
    private $orderLines;

    public function __construct($id, $orderDate, $shipmentDate, Customer $customer, $orderLines = array())
    {
        $this->id = $id;
        $this->orderDate = $orderDate;
        $this->shipmentDate = $shipmentDate;
        $this->customer = $customer;
        $this->orderLines = $orderLines;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function getShipmentDate()
    {
        return $this->shipmentDate;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return OrderLine[]
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

}