<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Model\Category;
use CoreBundle\Model\Path;
use CoreBundle\Repository\CategoryRepository;
use CoreBundle\Util\ValidateUtil;
use Doctrine\ORM\EntityManager;

class CategoryService extends EntityService
{

    protected $categoryRepository;

    public function __construct(EntityManager $entityManager, CategoryRepository $categoryRepository)
    {
        parent::__construct($entityManager);
        ValidateUtil::notNull($categoryRepository);
        $this->categoryRepository = $categoryRepository;
    }

    public function create(Path $path): Category
    {
        $categoryEntity = $this->categoryRepository->create($path);
        $this->flush();
        return CategoryMapper::mapToCategory($categoryEntity);
    }

    public function findByPath($path): Category
    {
        return CategoryMapper::mapToCategory($this->categoryRepository->findByPath($path));
    }

}