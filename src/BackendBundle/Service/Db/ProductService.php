<?php

namespace BackendBundle\Service\Db;

use BackendBundle\Form\ProductData;
use CoreBundle\Model\PathBuilder;
use CoreBundle\Model\Product;
use CoreBundle\Service\Db\ProductMapper;

class ProductService extends \CoreBundle\Service\Db\ProductService
{

    public function createOld(Product $product): Product
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

    public function create(ProductData $productData): Product
    {
        $path = PathBuilder::createByPath($productData->getCategoryPath());
        $categoryEntity = $this->categoryRepository->create($path);

        $imageEntities = array();
        foreach ($productData->getImages() as $image) {
            $imageEntities[] = $this->imageRepository->create(file_get_contents($image->getRealPath()));
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

}