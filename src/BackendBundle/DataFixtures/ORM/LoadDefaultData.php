<?php

namespace BackendBundle\DataFixtures\ORM;

use BackendBundle\Entity\AdministratorEntity;
use CoreBundle\Entity\CategoryEntityBuilder;
use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Entity\ProductEntity;
use CoreBundle\Entity\StockEntity;
use CoreBundle\Util\PasswordUtil;
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
        [6, 'monitor', 'pc/components/peripherals/monitor', 3],

        [7, 'Audio & Hi-Fi', 'audio & hi-fi', 0],
        [8, 'Office supplies', 'office supplies', 0],
        [9, 'Printers & Scanners', 'printers & scanners', 0],
        [10, 'TV & Video', 'tv & video', 0],
        [11, 'Cameras', 'cameras', 0],
        [12, 'Networking', 'networking', 0],
        [13, 'Storage', 'storage', 0],
        [14, 'Software', 'software', 0]
    ];

    private $products = [
        ['Lenovo ThinkCentre S510 SFF', 'Description...', 599.00, 1],
        ['HP ProDesk 400 G3 MT', 'Description...', 749.00, 1],
        ['Apple iMac Retina', 'Description...', 2099.00, 1],
        ['MSI Aegis 084', 'Description...', 1599.00, 1],
        ['Lenovo IdeaCentre 300-20ISH', 'Description...', 499.00, 1],
        ['Dell OptiPlex 7040 MT', 'Description...', 999.00, 1],

        ['Logitech MX Anywhere 2', 'Description...', 69.00, 4],
        ['Logitech MX Master', 'Description...', 85.00, 4],
        ['Logitech Wireless Mouse M705', 'Description...', 85.00, 4],
        ['Apple Magic Mouse 2', 'Description...', 79.00, 4],

        ['Dell U2715H', 'Description...', 499.00, 6],
        ['Samsung S24E650PL', 'Description...', 189.00, 6],
        ['Samsung U28E590D', 'Description...', 399.00, 6],
        ['ASUS PB287Q', 'Description...', 450.00, 6],
        ['ASUS ROG Swift PG348Q', 'Description...', 12806.00, 6],
    ];

    public function load(ObjectManager $manager)
    {
//        $this->loadAdministrators($manager);
//        $this->loadCategories($manager);
//        $this->loadProduct($manager);
//        $this->loadCustomers($manager);
//        $this->loadStocks($manager);
//        $manager->flush();
    }

    private function loadAdministrators(ObjectManager $manager)
    {
        foreach ($this->administrators() as $user) {
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

    private function administrators()
    {
        return [
            [1, 'Jason', 'Statham', 'admin@localhost.ch', 'ADMIN;EMPLOYEE', PasswordUtil::encrypt('admin')],
            [2, 'Liam', 'Neeson', 'employee@localhost.ch', 'EMPLOYEE', PasswordUtil::encrypt('admin')]
        ];
    }

    private function loadCategories(ObjectManager $manager)
    {
        $this->categoryEntities[0] = null;
        foreach ($this->categories as $category) {
            $categoryEntity = new CategoryEntityBuilder();
            $categoryEntity->setId($category[0]);
            $categoryEntity->setName($category[1]);
            $categoryEntity->setPath($category[2]);
            $categoryEntity->setParent($this->categoryEntities[$category[3]]);

            $this->categoryEntities[$category[0]] = $categoryEntity;
            $manager->persist($categoryEntity);
        }
    }

    private function loadProduct(ObjectManager $manager)
    {
        foreach ($this->products as $product) {
            $productEntity = new ProductEntity();
            $productEntity->setName($product[0]);
            $productEntity->setDescription($product[1]);
            $productEntity->setPrice($product[2]);
            $productEntity->setCategory($this->categoryEntities[$product[3]]);
            $manager->persist($productEntity);
        }
    }

    private function loadCustomers(ObjectManager $manager)
    {
        foreach ($this->customers() as $customer) {
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

    private function customers()
    {
        return [
            [1, 'Brad', 'Pitt', 'brad.pitt@localhost.ch', 'CUSTOMER', PasswordUtil::encrypt('customer')],
            [2, 'Angelina', 'Jolie', 'angelia.jolie@localhost.ch', 'CUSTOMER', PasswordUtil::encrypt('customer')]
        ];
    }

    private function loadStocks(ObjectManager $manager)
    {
        foreach ($this->stocks() as $stock) {
            $stockEntity = new StockEntity();
            $stockEntity->setProductId($stock[0]);
            $stockEntity->setInventoryDate($stock[1]);
            $stockEntity->setQuantity($stock[2]);
            $manager->persist($stockEntity);
        }
    }

    private function stocks()
    {
        $d = new \DateTime();

        return [
            [1, new \DateTime(), 5],
//            [2, $d->format('Y-m-d H:i:s'), 10],
//            [3, $d->format('Y-m-d H:i:s'), 15],
//            [4, $d->format('Y-m-d H:i:s'), 20],
//            [5, $d->format('Y-m-d H:i:s'), 25]
        ];
    }


}