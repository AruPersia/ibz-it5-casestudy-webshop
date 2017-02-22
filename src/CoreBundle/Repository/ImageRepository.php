<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\ImageEntity;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends AbstractRepository
{

    public function create($binary): ImageEntity
    {
        return $this->persist(ImageEntity::instance()->setBinary($binary));
    }

    protected function repository(): EntityRepository
    {
        return $this->createRepository('CoreBundle:ImageEntity');
    }


}