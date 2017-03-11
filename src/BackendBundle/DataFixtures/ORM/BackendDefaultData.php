<?php

namespace BackendBundle\DataFixtures\ORM;

use BackendBundle\Form\AdministratorData;
use BackendBundle\Form\ProductData;
use CoreBundle\DataFixtures\ORM\AbstractFixtureInterface;
use CoreBundle\Form\PasswordData;
use CoreBundle\Util\PasswordUtil;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\HttpFoundation\File\File;

class BackendDefaultData extends AbstractFixtureInterface implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    function loadData()
    {
        $this->loadAdministratorData();
        $this->loadProductData();
        $this->loadReorderData();
    }

    private function loadAdministratorData()
    {
        $administrators = array();
        $passwordData = PasswordData::builder()->setPassword(PasswordUtil::encrypt('123'));
        $administrators[] = $this->createAdministratorData('Emma', 'Stone', $passwordData);
        $administrators[] = $this->createAdministratorData('Jennifer', 'Aniston', $passwordData);
        $administrators[] = $this->createAdministratorData('Angelina', 'Jolie', $passwordData);
        foreach ($administrators as $administrator) {
            $this->administratorService()->create($administrator);
        }
    }

    private function createAdministratorData($firstName, $lastName, PasswordData $passwordData): AdministratorData
    {
        return AdministratorData::builder()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail(mb_strtolower($firstName . '.' . $lastName . '@localhost.local'))
            ->setPasswordData($passwordData);
    }

    private function loadProductData()
    {
        $products = array();

        $categoryPath = '/Peripherals/Keyboard & Mice/Mice';
        $products[] = $this->createProduct('Logitech MX Anywhere 2', $categoryPath, 69);
        $products[] = $this->createProduct('Logitech MX Master', $categoryPath, 85);
        $products[] = $this->createProduct('Apple Magic Mouse 2', $categoryPath, 79);
        $products[] = $this->createProduct('Logitech G G502 Proteus Spectrum RGB', $categoryPath, 69);

        $categoryPath = '/PC components/Hard drives/Server hard drives';
        $products[] = $this->createProduct('HPE 762263-B21 Solid State Disk', $categoryPath, 8076);
        $products[] = $this->createProduct('Fujitsu S26361-F3671-L400 Harddisk', $categoryPath, 747);

        $categoryPath = '/PC components/Hard drives/SSD';
        $products[] = $this->createProduct('Samsung 850 EVO Basic', $categoryPath, 173);
        $products[] = $this->createProduct('Samsung 960 EVO', $categoryPath, 245);
        $products[] = $this->createProduct('Samsung 850 Pro', $categoryPath, 139);
        $products[] = $this->createProduct('WD Blue', $categoryPath, 101);
        $products[] = $this->createProduct('Crucial MX300', $categoryPath, 298);

        $categoryPath = '/TV & Video/Televisions';
        $products[] = $this->createProduct('Samsung UE88KS9888', $categoryPath, 19799);
        $products[] = $this->createProduct('LG OLED65G6V', $categoryPath, 7499);
        $products[] = $this->createProduct('Sony KD-85XD8505', $categoryPath, 7299);
        $products[] = $this->createProduct('Samsung UE78KU6500', $categoryPath, 3999);

        $categoryPath = '/Notebooks & Tablets/Notebooks';
        $products[] = $this->createProduct('HP 250 G5', $categoryPath, 299);
        $products[] = $this->createProduct('Apple MacBook Pro Space Gray', $categoryPath, 85);
        $products[] = $this->createProduct('Microsoft Surface Book', $categoryPath, 2649);

        $categoryPath = '/Audio & Hi-fi/Hi-fi Streaming/Bluetooth & Portable speakers';
        $products[] = $this->createProduct('UE BOOM 2 black', $categoryPath, 149);
        $products[] = $this->createProduct('UE BOOM 2 blue', $categoryPath, 149);
        $products[] = $this->createProduct('UE BOOM 2 red', $categoryPath, 149);

        foreach ($products as $product) {
            $this->backendProductService()->create($product);
        }
    }

    private function createProduct($name, $categoryPath, $price)
    {
        $description = 'Lorem ipsum dolor sit amete, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat...';
        $images = $this->createImages($name);
        return ProductData::instance()
            ->setName($name)
            ->setDescription(sprintf('Some is description for: %s. %s', $name, $description))
            ->setCategoryPath($categoryPath)
            ->setPrice($price)
            ->setStockQuantity(10)
            ->setImages($images);
    }

    private function createImages($productName)
    {
        $imageFiles = array();
        $imageDir = sprintf('./tests/BackendBundle/Resources/images/%s/', $productName);
        $fileIterator = is_dir($imageDir) ? new \FilesystemIterator($imageDir, \FilesystemIterator::SKIP_DOTS) : array();

        foreach ($fileIterator as $file) {
            $imageFiles[] = new File($file->getRealPath());
        }

        return $imageFiles;
    }

    private function loadReorderData()
    {
        $products = $this->backendProductService()->findByPath('/');
        foreach ($products as $product) {
            $reorderId = $this->reorderService()->create($product->getId(), 20, new \DateTime(), new \DateTime());
            if ($reorderId % 2 == 0) {
                $this->reorderService()->updateDeliveredDate($reorderId);
            }
        }
    }

}