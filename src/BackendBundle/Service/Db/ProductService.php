<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\ProductData;
use CoreBundle\Model\Image;
use CoreBundle\Model\PathBuilder;
use CoreBundle\Model\Product;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Repository\ImageRepository;
use CoreBundle\Repository\ProductRepository;
use CoreBundle\Service\Db\ProductMapper;
use CoreBundle\Util\PathUtil;
use Doctrine\ORM\EntityManager;

class ProductService extends \CoreBundle\Service\Db\ProductService
{

    private $pathUtil;

    public function __construct(EntityManager $entityManager, ProductRepository $productRepository, CategoryRepository $categoryRepository, ImageRepository $imageRepository, PathUtil $pathUtil)
    {
        parent::__construct($entityManager, $productRepository, $categoryRepository, $imageRepository);
        $this->pathUtil = $pathUtil;
    }

    public function create(ProductData $productData): Product
    {
        $path = PathBuilder::createByPath($productData->getCategoryPath());
        $categoryEntity = $this->categoryRepository->create($path);

        $imageEntities = array();
        foreach ($productData->getImageFiles() as $image) {
            $imageEntities[] = $this->imageRepository->create(file_get_contents($image->getRealPath()));
        }

        if (empty($imageEntities)) {
            $imageEntities[] = $this->imageRepository->create(file_get_contents($this->pathUtil->getWebDir('images/no-product.jpg')));
        }

        $productEntity = $this->productRepository->create(
            $productData->getName(),
            $productData->getDescription(),
            $productData->getPrice(),
            $categoryEntity,
            array_shift($imageEntities),
            $imageEntities);

        $this->flush();

        return ProductMapper::mapToProduct($productEntity);
    }

    public function update(ProductData $productData): Product
    {
        $path = PathBuilder::createByPath($productData->getCategoryPath());
        $categoryEntity = $this->categoryRepository->create($path);

        $imageEntities = array();
        foreach ($productData->getImageFiles() as $image) {
            $imageEntities[] = $this->imageRepository->create(file_get_contents($image->getRealPath()));
        }

        $productEntity = $this->productRepository->update(
            $productData->getId(),
            $productData->getName(),
            $productData->getDescription(),
            $productData->getPrice(),
            $categoryEntity,
            $imageEntities
        );

        $this->flush();

        return ProductMapper::mapToProduct($productEntity);
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

    /**
     * @param $id - Product id
     * @param $imageId - Image id
     * @return Product
     */
    public function changeMainImage($id, $imageId): Product
    {
        $productEntity = $this->productRepository->changeMainImage($id, $imageId);
        $this->flush();
        return ProductMapper::mapToProduct($productEntity);
    }

    /**
     * @param $id
     * @return Product
     */
    public function toggleStatus($id): Product
    {
        $productEntity = $this->productRepository->toggleStatus($id);
        $this->flush();
        return ProductMapper::mapToProduct($productEntity);
    }

    public function findById($id): Product
    {
        return ProductMapper::mapToProduct($this->productRepository->findById($id));
    }

}