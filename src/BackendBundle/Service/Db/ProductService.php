<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\ProductData;
use CoreBundle\Entity\ProductEntity;
use CoreBundle\Service\Db\EntityManagerService;
use Doctrine\ORM\EntityManager;

class ProductService extends EntityManagerService
{
    private $categoryService;

    public function __construct(EntityManager $entityManager, CategoryService $categoryService)
    {
        parent::__construct($entityManager);
        $this->categoryService = $categoryService;
    }

    public function create(ProductData $productData)
    {
        $categoryEntity = $this->categoryService->assembleCategoryByPath($productData->getCategoryPath());

        $productEntity = new ProductEntity();
        $productEntity->setName($productData->getName());
        $productEntity->setPrice($productData->getPrice());
        $productEntity->setCategory($categoryEntity);

        $this->em->persist($productEntity);
        $this->em->flush();
    }

    public function save(ProductEntity $productEntity)
    {
        $this->em->persist($productEntity);
        $this->em->flush();
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository('CoreBundle:ProductEntity');
    }

}