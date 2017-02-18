<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CategoryEntity;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends AbstractRepository
{

    public function create($path): CategoryEntity
    {
        $entity = $this->findByPath($path);
        if ($entity == null) {
            $entity = CategoryEntity::instance()->setPath($path);
        }

        return $this->persist($entity);
    }

    /**
     * @param $path
     * @return CategoryEntity|null|object
     */
    public function findByPath($path)
    {
        return $this->repository()->findoneBy(['path' => $path]);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:CategoryEntity');
    }

}