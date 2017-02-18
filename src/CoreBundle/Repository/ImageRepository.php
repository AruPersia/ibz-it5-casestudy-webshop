<?php

namespace CoreBundle\Repository;


use CoreBundle\Entity\ImageEntity;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends AbstractRepository
{

    public function create($binary): ImageEntity
    {
        return $this->persist(ImageEntity::create($binary));
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:ImageEntity');
    }


}