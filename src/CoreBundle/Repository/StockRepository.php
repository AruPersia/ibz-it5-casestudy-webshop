<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\StockEntity;
use Doctrine\ORM\EntityRepository;

class SocketRepository extends EntityRepository
{

    /**
     * @param $productId
     * @return StockEntity|object
     */
    public function findOneByProductId($productId)
    {
        return $this->findOneBy(['productId' => $productId]);
    }

}