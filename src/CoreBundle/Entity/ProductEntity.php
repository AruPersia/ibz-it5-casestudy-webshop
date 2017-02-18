<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"categoryId", "name"})})
 */
class ProductEntity
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\CategoryEntity", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="id", nullable=FALSE)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=FALSE)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=FALSE)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=FALSE)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=FALSE)
     */
    private $enabled = true;

    /**
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\ImageEntity", cascade={"all"})
     * @ORM\JoinColumn(name="imageId", referencedColumnName="id")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\ImageEntity", cascade={"all"}, fetch="LAZY")
     * @ORM\JoinColumn(name="id", referencedColumnName="productId")
     * @ORM\JoinTable(name="productImage",
     *      joinColumns={@ORM\JoinColumn(name="productId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="imageId", referencedColumnName="id")}
     * )
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public static function instance(): ProductEntity
    {
        return new ProductEntity();
    }

    public function addImage(ImageEntity $imageEntity): ProductEntity
    {
        $this->images->add($imageEntity);
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): ProductEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CategoryEntity
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(CategoryEntity $category): ProductEntity
    {
        $this->category = $category;
        $this->category->getProducts()->add($this);
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): ProductEntity
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): ProductEntity
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): ProductEntity
    {
        $this->price = $price;
        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): ProductEntity
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return ImageEntity
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setImage(ImageEntity $image = null): ProductEntity
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return ArrayCollection|ImageEntity[]
     */
    public function getImages()
    {
        return $this->images;
    }

}