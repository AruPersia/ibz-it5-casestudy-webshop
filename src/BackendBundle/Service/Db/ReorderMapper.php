<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Model\Reorder;
use CoreBundle\Entity\ReorderEntity;
use CoreBundle\Service\Db\ProductMapper;
use CoreBundle\Util\ValidateUtil;

class ReorderMapper
{

    /**
     * @param ReorderEntity $reorderEntity
     * @return Reorder
     */
    public static function mapToReorder(ReorderEntity $reorderEntity): Reorder
    {
        ValidateUtil::notNull($reorderEntity);
        return new Reorder(
            $reorderEntity->getId(),
            ProductMapper::mapToProduct($reorderEntity->getProduct()),
            $reorderEntity->getQuantity(),
            $reorderEntity->getReorderedDate(),
            $reorderEntity->getExpectedDeliveryDate(), $reorderEntity->getDeliveredDate());
    }

    /**
     * @param ReorderEntity[] $reorderEntities
     * @return Reorder[]
     */
    public static function mapToReorders($reorderEntities)
    {
        $reorders = array();
        foreach ($reorderEntities as $reorder) {
            $reorders[] = self::mapToReorder($reorder);
        }

        return $reorders;
    }

}