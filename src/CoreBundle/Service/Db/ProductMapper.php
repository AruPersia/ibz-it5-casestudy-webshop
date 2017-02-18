<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\ProductEntity;
use CoreBundle\Model\Product;
use CoreBundle\Model\ProductBuilder;
use CoreBundle\Util\ValidateUtil;

class ProductMapper
{

    public static function mapToProduct(ProductEntity $productEntity): Product
    {
        ValidateUtil::notNull($productEntity);

        $category = CategoryMapper::mapToCategory($productEntity->getCategory());
        $image = ImageMapper::mapToImage($productEntity->getImage());
        $images = ImageMapper::mapToImages($productEntity->getImages());

        return ProductBuilder::instance()
            ->setId($productEntity->getId())
            ->setName($productEntity->getName())
            ->setDescription($productEntity->getDescription())
            ->setPrice($productEntity->getPrice())
            ->setEnabled($productEntity->getEnabled())
            ->setCategory($category)
            ->setImage($image)
            ->setImages($images)
            ->build();
    }

    /**
     * @param $productEntities
     * @return Product[]
     */
    public static function mapToProducts($productEntities)
    {
        $products = array();
        foreach ($productEntities as $productEntity) {
            $products[] = self::mapToProduct($productEntity);
        }

        return $products;
    }

}