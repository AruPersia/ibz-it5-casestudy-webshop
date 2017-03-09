<?php

namespace BackendBundle\Service\Db;

use CoreBundle\Model\Order;
use CoreBundle\Service\Db\OrderMapper;

class OrderService extends \CoreBundle\Service\Db\OrderService
{


    /**
     * @param $id - orderId
     * @return Order|null
     */
    public function findById($id)
    {
        return OrderMapper::mapToOrder($this->orderRepository->findById($id));
    }

    /**
     * @return Order[]
     */
    public function findOpenOrders()
    {
        return OrderMapper::mapToOrders($this->orderRepository->findOpenOrders());
    }

    /**
     * @param $maxResults
     * @return Order[]
     */
    public function findCompletedOrders($maxResults)
    {
        return OrderMapper::mapToOrders($this->orderRepository->findCompletedOrders($maxResults));
    }

    public function pendingOrdersSize()
    {
        return $this->orderRepository->pendingOrdersSize();
    }

    public function processedOrdersSize()
    {
        return $this->orderRepository->processedOrdersSize();
    }

    public function updateShipmentDate()
    {
        // TODO AAF
    }

}