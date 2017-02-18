<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Model\Category;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Util\ValidateUtil;
use Doctrine\ORM\EntityManager;

class CategoryService extends EntityService
{

    private $categoryRepository;

    public function __construct(EntityManager $entityManager, CategoryRepository $categoryRepository)
    {
        parent::__construct($entityManager);
        ValidateUtil::notNull($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Category $category): Category
    {
        $entity = $this->doCreate($category);
        $this->flush();
        return CategoryMapper::mapToCategory($entity);
    }

    private function doCreate(Category $category): CategoryEntity
    {
        $entity = $this->categoryRepository->create($category->getPath());
        foreach ($category->getChildren() as $child) {
            $entity->addChild($this->doCreate($child));
        }

        return $entity;
    }

}