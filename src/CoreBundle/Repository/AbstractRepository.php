<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Entity\ImageEntity;
use CoreBundle\Entity\ProductEntity;
use CoreBundle\Util\ValidateUtil;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     * @return CategoryEntity
     */
    public function categoryEntityRefById($id): CategoryEntity
    {
        return $this->entityManager->getReference('CoreBundle:CategoryEntity', $id);
    }

    /**
     * @param $id
     * @return ImageEntity
     */
    public function imageEntityRefById($id): ImageEntity
    {
        return $this->entityManager->getReference('CoreBundle:ImageEntity', $id);
    }

    /**
     * @param $id
     * @return CustomerEntity
     */
    public function customerEntityRefById($id): CustomerEntity
    {
        return $this->entityManager->getReference('CoreBundle:CustomerEntity', $id);
    }

    /**
     * @param $id
     * @return ProductEntity
     */
    public function productEntityRefById($id): ProductEntity
    {
        return $this->entityManager->getReference('CoreBundle:ProductEntity', $id);
    }

    /**
     * @param $entity
     * @return mixed
     */
    protected function persist($entity)
    {
        $this->entityManager->persist(ValidateUtil::notNull($entity));
        return $entity;
    }

    /**
     * @param $entity
     */
    protected function remove($entity)
    {
        $this->entityManager->remove(ValidateUtil::notNull($entity));
    }

    /**
     * @param $entity
     * @return mixed
     */
    protected function merge($entity)
    {
        return $this->entityManager->merge(ValidateUtil::notNull($entity));
    }

    protected function createRepository($name): EntityRepository
    {
        return $this->entityManager->getRepository($name);
    }

    abstract protected function repository(): EntityRepository;
}