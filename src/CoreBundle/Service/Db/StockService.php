<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Product;
use CoreBundle\Repository\StockRepository;
use Doctrine\ORM\EntityManager;

class StockService extends EntityService
{
    private $stockRepository;

    public function __construct(EntityManager $entityManager, StockRepository $stockRepository)
    {
        parent::__construct($entityManager);
        $this->stockRepository = $stockRepository;
    }

    public function addProduct(Product $product, $quantity)
    {
        $stockEntity = $this->stockRepository->addProduct($product->getId(), $quantity);
        $this->flush();
        return $stockEntity->getQuantity();
    }

}