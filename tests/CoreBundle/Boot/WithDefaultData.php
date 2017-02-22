<?php
namespace Tests\CoreBundle\Boot;

use CoreBundle\Entity\CustomerEntity;
use CoreBundle\Model\Category;
use CoreBundle\Model\Image;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Model\PathBuilder;
use CoreBundle\Model\Product;
use CoreBundle\Model\ProductBuilder;

class WithDefaultData extends KernelTestCaseWithDbSupport
{
    protected function setUp()
    {
        parent::setUp();

        $this->createSomeCustomers();
        for ($i = 0; $i < 10; $i++) {
            $this->productService()->create($this->createDefaultProduct());
        }
    }

    private function createSomeCustomers()
    {
        for ($i = 1; $i < 10; $i++) {
            $customer = new CustomerEntity();
            $customer->setEmail('customer_' . $i . '@gmail.com');
            $customer->setFirstName('Brad ' . $i);
            $customer->setLastName('Pitt' . $i);
            $customer->setPassword('123456');
            $customer->setRoles('CUSTOMER');
            $this->em->persist($customer);
        }

        $this->em->flush();
    }

    private function createDefaultProduct(): Product
    {
        $name = 'Samsung Galaxy S7 - ' . uniqid();
        $description = 'Some description - ' . uniqid();
        $category = new Category(null, PathBuilder::createByPath('Mobile/Samsung'));
        return $product = ProductBuilder::instance()
            ->setName($name)
            ->setDescription($description)
            ->setPrice(12)
            ->setCategory($category)
            ->setImage(ImageBuilder::instance()->setBinary($this->getSomePngBinary())->build())
            ->setImages($this->createDefaultImages(5))
            ->build();
    }

    private function getSomePngBinary()
    {
        return file_get_contents('./web/bundles/framework/images/logo_symfony.png');
    }

    /**
     * @param $quantity
     * @return Image[]
     */
    private function createDefaultImages($quantity)
    {
        $images = array();
        for ($i = 0; $i < $quantity; $i++) {
            $images[] = ImageBuilder::instance()->setBinary($i . $this->getSomePngBinary())->build();
        }
        return $images;
    }

}