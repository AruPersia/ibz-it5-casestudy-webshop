<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\OrderEntity;
use CoreBundle\Model\Order;
use CoreBundle\Model\OrderBuilder;
use CoreBundle\Util\ValidateUtil;

class OrderMapper
{

    public static function mapToOrder(OrderEntity $orderEntity): Order
    {
        ValidateUtil::notNull($orderEntity);
        return OrderBuilder::instance()
            ->setId($orderEntity->getId())
            ->setOrderDate($orderEntity->getOrderDate())
            ->setShipmentDate($orderEntity->getShipmentDate())
            ->setCustomer(CustomerMapper::mapToCustomer($orderEntity->getCustomer()))
            ->setOrderLines(OrderLineMapper::mapToOrderLines($orderEntity->getOrderLines()))
            ->build();
    }

    /**
     * @param OrderEntity[] $orderEntities
     * @return array
     */
    public static function mapToOrders($orderEntities)
    {
        $orders = array();
        foreach ($orderEntities as $orderEntity) {
            $orders[] = self::mapToOrder($orderEntity);
        }

        return $orders;
    }


}