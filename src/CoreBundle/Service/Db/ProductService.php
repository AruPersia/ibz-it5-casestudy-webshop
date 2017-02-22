<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Model\Category;
use CoreBundle\Model\Image;
use CoreBundle\Model\Product;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;

class ProductService extends EntityService
{

    private $productRepository;
    private $categoryRepository;
    private $imageRepository;

    public function __construct(EntityManager $entityManager, ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository)
    {
        parent::__construct($entityManager);
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->imageRepository = $imageRepository;
    }

    public function create(Product $product): Product
    {
        $categoryEntity = $this->categoryRepository->create($product->getCategory()->getPath());
        $imageEntity = $this->imageRepository->create($product->getImage()->getBinary());
        $imageEntities = array();

        foreach ($product->getImages() as $image) {
            $imageEntities[] = $this->imageRepository->create($image->getBinary());
        }

        $entity = $this->productRepository->create(
            $product->getName(),
            $product->getDescription(),
            $product->getPrice(),
            $categoryEntity,
            $imageEntity,
            $imageEntities
        );

        $this->flush();
        return ProductMapper::mapToProduct($entity);
    }

    /**
     * @param $id
     * @param Image[] $images
     * @return Product
     */
    public function addImages($id, $images = array()): Product
    {
        $imageEntities = array();
        foreach ($images as $image) {
            $imageEntities[] = $this->imageRepository->create($image->getBinary());
        }

        $productEntity = $this->productRepository->addImages($id, $imageEntities);
        $this->flush();

        return ProductMapper::mapToProduct($productEntity);
    }

    /**
     * @param $id - Product id
     * @param array $imageEntityIds - Image ids which should be deleted
     * @return Product
     */
    public function removeImages($id, $imageEntityIds = array()): Product
    {
        $productEntity = $this->productRepository->removeImages($id, $imageEntityIds);
        $this->flush();
        return ProductMapper::mapToProduct($productEntity);
    }

    public function findById($id): Product
    {
        return ProductMapper::mapToProduct($this->productRepository->findById($id));
    }

    /**
     * @param $path
     * @return Product[]
     */
    public function findByCategoryPath($path)
    {
        $categoryEntity = $this->categoryRepository->findByPath($path);
        return ProductMapper::mapToProducts($this->productRepository->findByCategory($categoryEntity));
    }

    private function createCategory(Category $category, CategoryEntity $parent = null): CategoryEntity
    {
        $categoryEntity = $this->categoryRepository->create($category->getPath());
        $categoryEntity->setParent($parent);

        foreach ($category->getChildren() as $child) {
            $this->createCategory($child, $categoryEntity);
        }

        return $categoryEntity;
    }

}