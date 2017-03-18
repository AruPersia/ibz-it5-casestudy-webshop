<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\OrderEntity;
use CoreBundle\Entity\OrderLineEntity;
use CoreBundle\Model\OrderLine;
use CoreBundle\Model\OrderLineBuilder;

class OrderLineMapper
{

    public static function mapToOrderLine(OrderLineEntity $orderLineEntity): OrderLine
    {
        return OrderLineBuilder::instance()
            ->setId($orderLineEntity->getId())
            ->setProduct(ProductMapper::mapToProduct($orderLineEntity->getProduct()))
            ->setPrice($orderLineEntity->getPrice())
            ->setQuantity($orderLineEntity->getQuantity())
            ->build();
    }

    /**
     * @param OrderEntity[] $orderLineEntities
     * @return OrderLine[]
     */
    public static function mapToOrderLines($orderLineEntities)
    {
        $orderLines = array();
        foreach ($orderLineEntities as $orderLineEntity) {
            $orderLines[] = self::mapToOrderLine($orderLineEntity);
        }
        return $orderLines;
    }
}