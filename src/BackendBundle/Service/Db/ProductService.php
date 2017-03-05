<?php

namespace BackendBundle\Service\Db;

use CoreBundle\Model\Product;
use CoreBundle\Service\Db\ProductMapper;

class ProductService extends \CoreBundle\Service\Db\ProductService
{

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

}