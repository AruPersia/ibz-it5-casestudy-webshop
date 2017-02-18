<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Model\Category;
use CoreBundle\Model\CategoryBuilder;

class CategoryMapper
{

    /**
     * @param CategoryEntity|null $categoryEntity
     * @return Category
     */
    public static function mapToCategory(CategoryEntity $categoryEntity = null)
    {
        if ($categoryEntity == null) {
            return null;
        }

        $builder = CategoryBuilder::instance()
            ->setId($categoryEntity->getId())
            ->setPath($categoryEntity->getPath());

        foreach ($categoryEntity->getChildren() as $childEntity) {
            $childBuilder = CategoryBuilder::instance()
                ->setId($childEntity->getId())
                ->setPath($childEntity->getPath());

            $builder->addChild($childBuilder);
        }

        return $builder->build();
    }

}