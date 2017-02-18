<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class ImageEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="blob", name="`binary`")
     */
    private $binary;

    public static function create($binary): ImageEntity
    {
        $mageEntity = new ImageEntity();
        $mageEntity->setBinary($binary);
        return $mageEntity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): ImageEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getBinary()
    {
        return $this->binary;
    }

    public function setBinary($binary): ImageEntity
    {
        $this->binary = $binary;
        return $this;
    }

}