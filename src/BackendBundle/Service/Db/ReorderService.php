<?php

namespace BackendBundle\Service\Db;

use CoreBundle\Repository\ProductRepository;
use CoreBundle\Repository\ReorderRepository;
use CoreBundle\Service\Db\EntityService;
use Doctrine\ORM\EntityManager;

class ReorderService extends EntityService
{

    private $reorderRepository;
    private $productRepository;

    public function __construct(EntityManager $entityManager, ReorderRepository $reorderRepository, ProductRepository $productRepository)
    {
        parent::__construct($entityManager);
        $this->reorderRepository = $reorderRepository;
        $this->productRepository = $productRepository;
    }

    public function create($productId, $quantity, $reorderedDate, $expectedDeliveryDate)
    {
        $reorderEntity = $this->reorderRepository->create($productId, $quantity, $reorderedDate, $expectedDeliveryDate);
        $this->flush();
        // TODO AAF: return the model
        return $reorderEntity->getId();
    }

    public function updateDeliveredDate($reorderId)
    {
        $reorderEntity = $this->reorderRepository->updateDeliveredDate($reorderId, new \DateTime());
        $productEntity = $reorderEntity->getProduct();
        $productEntity->setStockQuantity($productEntity->getStockQuantity() + $reorderEntity->getQuantity());
        $this->flush();
        // TODO AAF: return the model
    }

}