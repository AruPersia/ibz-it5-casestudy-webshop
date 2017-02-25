<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\ProductEntity;
use CoreBundle\Entity\StockEntity;
use Doctrine\ORM\EntityRepository;

class StockRepository extends AbstractRepository
{
    public function addProduct($productId, $quantity): StockEntity
    {
        $productEntity = $this->productEntityRefById($productId);
        $stockEntity = $this->findByProductOrCreate($productEntity)
            ->setInventoryDate(new \DateTime())
            ->changeQuantity($quantity);

        return $this->persist($stockEntity);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:StockEntity');
    }

    private function findByProductOrCreate(ProductEntity $productEntity): StockEntity
    {
        $stockEntity = $this->findByProduct($productEntity);
        if ($stockEntity == null) {
            $stockEntity = StockEntity::instance()
                ->setQuantity(0)
                ->setProduct($productEntity);
        }

        return $stockEntity;
    }

    /**
     * @return StockEntity|null|object
     */
    private function findByProduct(ProductEntity $productEntity)
    {
        return $this->repository()->findOneBy(['product' => $productEntity]);
    }

}