<?php

namespace AppBundle\Service\Db;

use AppBundle\Entity\ProductEntity;

class ProductService extends DbBaseService
{

    public function save(ProductEntity $productEntity)
    {
        $this->em->persist($productEntity);
        $this->em->flush();
    }

}