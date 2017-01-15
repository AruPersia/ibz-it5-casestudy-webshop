<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class CategoryEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\CategoryEntity", inversedBy="children", fetch="LAZY")
     * @ORM\JoinColumn(name="parentCategoryId", referencedColumnName="id", nullable=TRUE)
     */
    private $parentCategory;

    /**
     * @var CategoryEntity[]
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\CategoryEntity", mappedBy="parentCategory", cascade={"remove", "persist"}, fetch="LAZY")
     */
    private $children;

    /**
     * @var ProductEntity[]
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\ProductEntity", mappedBy="category", cascade={"remove", "persist"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = strtolower($path);
    }

    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * @return CategoryEntity
     * @param $parentCategory
     */
    public function setParentCategory($parentCategory)
    {
        $this->parentCategory = $parentCategory;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products)
    {
        $this->products = $products;
    }

    public function addProduct(ProductEntity $productEntity)
    {
        $this->products->add($productEntity);
        $productEntity->setCategory($this);
    }

    function __toString()
    {
        return sprintf('%s [%d]', $this->getName(), $this->getId());
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


}