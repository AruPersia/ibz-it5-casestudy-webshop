<?php

namespace BackendBundle\Model;

class Dashboard
{

    private $orders;

    public function __construct(Orders $orders)
    {
        $this->orders = $orders;
    }

    public function getOrders(): Orders
    {
        return $this->orders;
    }

}