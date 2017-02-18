<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\ImageEntity;
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

    /**
     * @param $id
     * @return ImageEntity
     */
    protected function imageEntityRefById($id): ImageEntity
    {
        return $this->entityManager->getReference('CoreBundle:ImageEntity', $id);
    }

    protected function createRepository($name): EntityRepository
    {
        return $this->entityManager->getRepository($name);
    }

    abstract protected function repository(): EntityRepository;
}