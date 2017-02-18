<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class CategoryEntity implements Entity
{

    const DELIMITER = '/';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\CategoryEntity", inversedBy="children", fetch="LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="parentCategoryId", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\CategoryEntity", mappedBy="parent", fetch="LAZY")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\ProductEntity", mappedBy="category", fetch="EAGER")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public static function instance(): CategoryEntity
    {
        return new CategoryEntity();
    }

    public static function pathToName($path)
    {
        return self::extractName(self::removeSlashes($path));
    }

    private static function removeSlashes($path): String
    {
        return ltrim(rtrim($path, self::DELIMITER), self::DELIMITER);
    }

    private static function extractName($path): String
    {
        $strings = explode(self::DELIMITER, $path);
        return end($strings);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = self::removeSlashes($path);
        $this->name = self::pathToName($path);
        return $this;
    }

    /**
     * @return CategoryEntity|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return CategoryEntity
     * @param $parent
     */
    public function setParent(CategoryEntity $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    public function hasParent()
    {
        return $this->parent != null;
    }

    /**
     * @return ArrayCollection|CategoryEntity[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(CategoryEntity $categoryEntity)
    {
        $this->children->add($categoryEntity);
        $categoryEntity->setParent($this);
        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(ProductEntity $productEntity)
    {
        $this->products->add($productEntity);
        $productEntity->setCategory($this);
        return $this;
    }

    function __toString()
    {
        return sprintf('%s [%d]', $this->getName(), $this->getId());
    }

}