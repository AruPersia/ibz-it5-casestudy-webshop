<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\ReorderEntity;
use Doctrine\ORM\EntityRepository;

class ReorderRepository extends AbstractRepository
{

    /**
     * @param $productId - Product id
     * @param $quantity - Quantity of reorderung
     * @param $reorderedDate - Reordering date
     * @param $expectedDeliveryDate - Expected reordering date
     * @return ReorderEntity
     */
    public function create($productId, $quantity, $reorderedDate, $expectedDeliveryDate): ReorderEntity
    {
        return $this->persist(ReorderEntity::instance()
            ->setProduct($this->productEntityRefById($productId))
            ->setQuantity($quantity)
            ->setReorderedDate($reorderedDate)
            ->setExpectedDeliveryDate($expectedDeliveryDate));
    }

    /**
     * @param $id - ReorderEntity id
     * @param $deliveredDate - Date of delivered reordering
     * @return ReorderEntity
     */
    public function updateDeliveredDate($id, $deliveredDate): ReorderEntity
    {
        $reorderEntity = $this->findById($id);
        $reorderEntity->setDeliveredDate($deliveredDate);
        return $this->persist($reorderEntity);
    }

    /**
     * @param $id - ReorderEntity id
     * @return ReorderEntity|null|object
     */
    public function findById($id)
    {
        return $this->repository()->find($id);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:ReorderEntity');
    }

}