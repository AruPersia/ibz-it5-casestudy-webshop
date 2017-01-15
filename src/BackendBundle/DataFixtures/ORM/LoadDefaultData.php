<?php

namespace BackendBundle\DataFixtures\ORM;

use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Entity\ProductEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDefaultData implements FixtureInterface
{

    private $categoryEntities = array();
    private $categories = [
        [1, 'pc', 'pc', 0],
        [2, 'components', 'pc/components', 1],
        [3, 'peripherals', 'pc/components/peripherals', 2],
        [4, 'mice', 'pc/components/peripherals/mice', 3],
        [5, 'keyboard', 'pc/components/peripherals/keyboard', 3],
        [6, 'monitor', 'pc/components/peripherals/monitor', 3]
    ];

    private $products = [
        ['Logitech MX Anywhere 2', 69.00, 4],
        ['Logitech MX Master', 85.00, 4],
        ['Logitech Wireless Mouse M705', 85.00, 4],
        ['Apple Magic Mouse 2', 79.00, 4],

        ['Dell U2715H', 499.00, 6],
        ['Samsung S24E650PL', 189.00, 6],
        ['Samsung U28E590D', 399.00, 6],
        ['ASUS PB287Q', 450.00, 6],
        ['ASUS ROG Swift PG348Q', 12806.00, 6],
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadProduct($manager);
        $manager->flush();
    }

    private function loadCategories(ObjectManager $manager)
    {
        $this->categoryEntities[0] = null;
        foreach ($this->categories as $category) {
            $categoryEntity = new CategoryEntity();
            $categoryEntity->setId($category[0]);
            $categoryEntity->setName($category[1]);
            $categoryEntity->setPath($category[2]);
            $categoryEntity->setParentCategory($this->categoryEntities[$category[3]]);

            $this->categoryEntities[$category[0]] = $categoryEntity;
            $manager->persist($categoryEntity);
        }
    }

    private function loadProduct(ObjectManager $manager)
    {
        foreach ($this->products as $product) {
            $productEntity = new ProductEntity();
            $productEntity->setName($product[0]);
            $productEntity->setPrice($product[1]);
            $productEntity->setCategory($this->categoryEntities[$product[2]]);
            $manager->persist($productEntity);
        }
    }


}