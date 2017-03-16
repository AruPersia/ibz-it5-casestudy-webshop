<?php

namespace CoreBundle\Model;

class Order
{

    private $id;
    private $orderDate;
    private $shipmentDate;
    private $customer;
    private $deliveryAddress;
    private $orderLines;

    public function __construct($id, $orderDate, $shipmentDate, Customer $customer, Address $deliveryAddress, $orderLines = array())
    {
        $this->id = $id;
        $this->orderDate = $orderDate;
        $this->shipmentDate = $shipmentDate;
        $this->customer = $customer;
        $this->deliveryAddress = $deliveryAddress;
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

    public function getDeliveryAddress(): Address
    {
        return $this->deliveryAddress;
    }

    /**
     * @return OrderLine[]
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    public function getSum()
    {
        $total = 0;
        foreach ($this->getOrderLines() as $orderLine) {
            $total += $orderLine->getSum();
        }
        return $total;
    }

}