<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\ProductEntity;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{

    /**
     * @param $productId
     * @return ProductEntity|object
     */
    public function findOneByProductId($productId)
    {
        return $this->findOneBy(['id' => $productId]);
    }

    /**
     * @param $categoryId
     * @return ProductEntity[]
     */
    public function findByCategoryId($categoryId)
    {
        return $this->findBy(['category' => $categoryId]);
    }

}