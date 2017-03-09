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
        $productEntity = ProductEntity::instance()
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setCategory($category)
            ->setImage($image);

        foreach ($images as $image) {
            $productEntity->addImage($image);
        }

        return $this->persist($productEntity);
    }

    public function update($id, $name, $description, $price, CategoryEntity $category, $images = array()): ProductEntity
    {
        ValidateUtil::notNulls($id, $name, $description, $price, $category);

        $productEntity = $this->findById($id)
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setCategory($category);

        foreach ($images as $image) {
            $productEntity->getImages()->add($image);
        }

        return $this->merge($productEntity);
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
     * @param $imageId - Image id
     * @return ProductEntity
     */
    public function changeMainImage($id, $imageId): ProductEntity
    {
        $imageEntity = $this->findById($id);
        foreach ($imageEntity->getImages() as $image) {
            if ($image->getId() == $imageId) {
                $imageEntity->getImages()->removeElement($image);
                $imageEntity->getImages()->add($imageEntity->getImage());
                $imageEntity->setImage($image);
            }
        }

        return $this->merge($imageEntity);
    }

    /**
     * @param $id - Product id
     * @return ProductEntity
     */
    public function toggleStatus($id): ProductEntity
    {
        $productEntity = $this->findById($id);
        $productEntity->setEnabled(!$productEntity->getEnabled());
        return $this->persist($productEntity);
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
     * @param String $path
     * @param $includeDisabled - With disabled products
     * @return ProductEntity[]
     */
    public function findByPath(String $path, $includeDisabled = false)
    {
        $queryBuilder = $this->repository()
            ->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->where('c.path like :path');

        if (!$includeDisabled) {
            $queryBuilder->andWhere('p.enabled = 1');
        }

        return $queryBuilder
            ->setParameter('path', $path . '%')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:ProductEntity');
    }

}