<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Model\Path;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends AbstractRepository
{

    public function create(Path $path): CategoryEntity
    {
        $categoryEntity = $this->findByPath($path->getPath());

        if ($categoryEntity == null) {
            $categoryEntity = CategoryEntity::instance()->setPath($path->getPath());
            if ($path->getParent() != null) {
                $categoryEntity->setParent($this->create($path->getParent()));
            }
        }

        return $this->persist($categoryEntity);
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