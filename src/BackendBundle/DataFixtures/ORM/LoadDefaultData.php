<?php

namespace BackendBundle\DataFixtures\ORM;

use BackendBundle\Entity\AdministratorEntity;
use CoreBundle\Entity\CategoryEntity;
use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Entity\ProductEntity;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDefaultData implements FixtureInterface
{

    private $administrators = [
        [1, 'Jason', 'Statham', 'admin@localhost.ch', 'ADMIN;EMPLOYEE', '$2y$13$rOOTFHElgu6xwsXE60shN.LYdbCzUaUGsynMXuVw1xBeatoAuPtvC'],
        [2, 'Liam', 'Neeson', 'employee@localhost.ch', 'EMPLOYEE', '$2y$13$rOOTFHElgu6xwsXE60shN.LYdbCzUaUGsynMXuVw1xBeatoAuPtvC']
    ];

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
        ['Lenovo ThinkCentre S510 SFF', 599.00, 1],
        ['HP ProDesk 400 G3 MT', 749.00, 1],
        ['Apple iMac Retina', 2099.00, 1],
        ['MSI Aegis 084', 1599.00, 1],
        ['Lenovo IdeaCentre 300-20ISH', 499.00, 1],
        ['Dell OptiPlex 7040 MT', 999.00, 1],

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

    private $customers = [
        [1, 'Brad', 'Pitt', 'brad.pitt@localhost.ch', 'CUSTOMER', '$2y$13$rOOTFHElgu6xwsXE60shN.LYdbCzUaUGsynMXuVw1xBeatoAuPtvC'],
        [2, 'Angelina', 'Jolie', 'angelia.jolie@localhost.ch', 'CUSTOMER', '$2y$13$rOOTFHElgu6xwsXE60shN.LYdbCzUaUGsynMXuVw1xBeatoAuPtvC']
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadAdministrators($manager);
        $this->loadCategories($manager);
        $this->loadProduct($manager);
        $this->loadCustomers($manager);
        $manager->flush();
    }

    private function loadAdministrators(ObjectManager $manager)
    {
        foreach ($this->administrators as $user) {
            $administratorEntity = new AdministratorEntity();
            $administratorEntity->setId($user[0]);
            $administratorEntity->setFirstName($user[1]);
            $administratorEntity->setLastName($user[2]);
            $administratorEntity->setEmail($user[3]);
            $administratorEntity->setRoles($user[4]);
            $administratorEntity->setPassword($user[5]);

            $manager->persist($administratorEntity);
        }
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

    private function loadCustomers(ObjectManager $manager)
    {
        foreach ($this->customers as $customer) {
            $customerEntity = new CustomerEntity();
            $customerEntity->setId($customer[0]);
            $customerEntity->setFirstName($customer[1]);
            $customerEntity->setLastName($customer[2]);
            $customerEntity->setEmail($customer[3]);
            $customerEntity->setRoles($customer[4]);
            $customerEntity->setPassword($customer[5]);
            $manager->persist($customerEntity);
        }
    }


}