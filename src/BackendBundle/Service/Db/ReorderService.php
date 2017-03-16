<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Model\Reorder;
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

    public function create($productId, $quantity, $reorderedDate, $expectedDeliveryDate): Reorder
    {
        $reorderEntity = $this->reorderRepository->create($productId, $quantity, $reorderedDate, $expectedDeliveryDate);
        $this->flush();
        return ReorderMapper::mapToReorder($reorderEntity);
    }

    public function updateDeliveredDate($reorderId): Reorder
    {
        $reorderEntity = $this->reorderRepository->updateDeliveredDate($reorderId, new \DateTime());
        $productEntity = $reorderEntity->getProduct();
        $productEntity->setStockQuantity($productEntity->getStockQuantity() + $reorderEntity->getQuantity());
        $this->flush();
        return ReorderMapper::mapToReorder($reorderEntity);
    }

    /**
     * @return Reorder[]
     */
    public function findPending()
    {
        return ReorderMapper::mapToReorders($this->reorderRepository->findPending());
    }

    /**
     * @param $maxResults
     * @return Reorder[]
     */
    public function findDelivered($maxResults)
    {
        return ReorderMapper::mapToReorders($this->reorderRepository->findDelivered($maxResults));
    }

}