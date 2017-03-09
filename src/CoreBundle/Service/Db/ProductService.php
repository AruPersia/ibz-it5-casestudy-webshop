<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Product;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;

class ProductService extends EntityService
{

    protected $productRepository;
    protected $categoryRepository;
    protected $imageRepository;

    public function __construct(EntityManager $entityManager, ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository)
    {
        parent::__construct($entityManager);
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param $path
     * @param $includeDisabled - With disabled products
     * @return Product[]
     */
    public function findByPath($path, $includeDisabled = false)
    {
        return ProductMapper::mapToProducts($this->productRepository->findByPath($path, $includeDisabled));
    }

}