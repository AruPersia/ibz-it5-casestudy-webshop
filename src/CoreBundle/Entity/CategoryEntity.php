<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class CategoryEntity implements EntityBuilder
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): CategoryEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): CategoryEntity
    {
        $this->path = $path;
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

    public function getRoot()
    {
        $root = $this;
        while ($root->hasParent()) {
            $root = $root->getParent();
        }
        return $root;
    }

    function __toString()
    {
        return sprintf('%s [%d]', $this->getId(), $this->getPath());
    }

}