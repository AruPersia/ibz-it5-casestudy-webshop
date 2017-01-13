<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\ProductData;
use CoreBundle\Entity\ProductEntity;
use CoreBundle\Service\Db\EntityManagerService;
use Doctrine\ORM\EntityManager;

class ProductService extends EntityManagerService
{
    private $categoryPathExtractorService;

    public function __construct(EntityManager $entityManager, CategoryPathExtractorService $categoryPathExtractorService)
    {
        parent::__construct($entityManager);
        $this->categoryPathExtractorService = $categoryPathExtractorService;
    }

    public function create(ProductData $productData)
    {
        $productEntity = new ProductEntity();
        $productEntity->setName($productData->getName());
        $productEntity->setPrice($productData->getPrice());

        $categoryEntity = $this->categoryPathExtractorService->getCategoryEntity($productData->getCategory());
        $categoryEntity->addProduct($productEntity);

        $this->em->flush();
    }

    public function save(ProductEntity $productEntity)
    {
        $this->em->persist($productEntity);
        $this->em->flush();
    }

}