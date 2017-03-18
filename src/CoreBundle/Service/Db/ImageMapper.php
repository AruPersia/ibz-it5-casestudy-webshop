<?php

namespace CoreBundle\Service\Db;

use CoreBundle\Entity\ImageEntity;
use CoreBundle\Model\Image;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Util\ValidateUtil;

class ImageMapper
{

    public static function mapToImage(ImageEntity $imageEntity): Image
    {
        ValidateUtil::notNull($imageEntity);

        return ImageBuilder::instance()
            ->setId($imageEntity->getId())
            ->setBinary($imageEntity->getBinary())
            ->build();
    }

    /**
     * @param ImageEntity[] $imageEntities
     * @return array
     */
    public static function mapToImages($imageEntities = array())
    {
        $images = array();
        foreach ($imageEntities as $imageEntity) {
            $images[] = self::mapToImage($imageEntity);
        }

        return $images;
    }

}