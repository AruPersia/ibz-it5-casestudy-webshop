<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Entity\ImageEntity;
use CoreBundle\Entity\ProductEntity;
use CoreBundle\Util\ValidateUtil;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends AbstractRepository
{

    public function create($name, $description, $price, CategoryEntity $category, ImageEntity $image, $images = array()): ProductEntity
    {
        ValidateUtil::notNulls($name, $description, $price, $category, $image);
        $entity = ProductEntity::instance()
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setCategory($category)
            ->setImage($image);

        foreach ($images as $image) {
            $entity->addImage($image);
        }

        return $this->persist($entity);
    }

    /**
     * @param $id - Product id
     * @param ImageEntity[] $imageEntities
     * @return ProductEntity
     */
    public function addImages($id, $imageEntities): ProductEntity
    {
        $productEntity = $this->findById($id);
        foreach ($imageEntities as $imageEntity) {
            ValidateUtil::notNull($imageEntity);
            $productEntity->addImage($imageEntity);
        }

        return $this->persist($productEntity);
    }

    /**
     * @param $id - Product id
     * @param $imageEntityIds - Image ids which should be deleted
     * @return ProductEntity
     */
    public function removeImages($id, $imageEntityIds): ProductEntity
    {
        $entity = $this->findById($id);
        foreach ($imageEntityIds as $imageEntityId) {
            $imageEntityRef = $this->imageEntityRefById($imageEntityId);
            $entity->getImages()->removeElement($imageEntityRef);
            $this->remove($imageEntityRef);
        }

        return $this->merge($entity);
    }

    /**
     * @param $id - Product id
     * @return ProductEntity
     */
    public function findById($id): ProductEntity
    {
        return $this->repository()
            ->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', ValidateUtil::notNull($id))
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param CategoryEntity $categoryEntity
     * @return ProductEntity[]
     */
    public function findByCategory(CategoryEntity $categoryEntity)
    {
        return $this->repository()->findBy(['category' => $categoryEntity]);
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:ProductEntity');
    }

}