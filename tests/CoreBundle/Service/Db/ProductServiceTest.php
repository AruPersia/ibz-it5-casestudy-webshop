<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\Category;
use CoreBundle\Model\Image;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Model\PathBuilder;
use CoreBundle\Model\Product;
use CoreBundle\Model\ProductBuilder;
use Tests\CoreBundle\Boot\TestWithDb;

class ProductServiceTest extends TestWithDb
{

    public function testCreateProductShouldWorkProperly()
    {
        // given
        $product = $this->createDefaultProduct();

        // when
        $createdProduct = $this->productService()->create($product);

        // then
        $this->assertEquals(1, $createdProduct->getId());
        $this->assertEquals($this->getSomePngBinary(), $createdProduct->getImage()->getBinary());
        $this->assertProductWithoutId($product, $createdProduct);
    }

    public function testFindProductByIdShouldWorkProperly()
    {
        // given
        $product = $this->productService()->create($this->createDefaultProduct());

        // when
        $foundedProduct = $this->productService()->findById(1);

        // then
        $this->assertProduct($product, $foundedProduct);
    }

    public function testFindByCategoryPathShouldWorkProperly()
    {
        // given
        for ($i = 0; $i < 10; $i++) {
            $this->productService()->create($this->createDefaultProduct('/Mobile/Samsung'));
            $this->productService()->create($this->createDefaultProduct('/Mobile/Apple'));
        }

        // when
        $allProducts = $this->productService()->findByPath('/');
        $mobiles = $this->productService()->findByPath('/Mobile');
        $samsungMobiles = $this->productService()->findByPath('/Mobile/Samsung');
        $appleMobiles = $this->productService()->findByPath('/Mobile/Samsung');

        // then
        $this->assertCount(20, $allProducts);
        $this->assertCount(20, $mobiles);
        $this->assertCount(10, $samsungMobiles);
        $this->assertCount(10, $appleMobiles);
    }

    public function testAddImageShouldWorkProperly()
    {
        // given
        $product = $this->productService()->create($this->createDefaultProduct());
        $images = $this->createDefaultImages(2);

        // when
        $updatedProduct = $this->productService()->addImages($product->getId(), $images);

        // then
        $this->assertCount(5, $product->getImages());
        $this->assertCount(7, $updatedProduct->getImages());
        $this->assertProduct($product, $updatedProduct);
    }

    public function testDeleteImagesShouldWorkProperly()
    {
        // given
        $product = $this->productService()->create($this->createDefaultProduct());
        $imageEntityIds = array();
        foreach ($product->getImages() as $images) {
            $imageEntityIds[] = $images->getId();
        }

        // when
        $updatedProduct = $this->productService()->removeImages($product->getId(), $imageEntityIds);

        // then
        $this->assertCount(5, $product->getImages());
        $this->assertCount(0, $updatedProduct->getImages());
        $this->assertProduct($product, $updatedProduct);
    }

    private function assertProduct(Product $expected, Product $actual)
    {
        $this->assertEquals($expected->getId(), $actual->getId());
        $this->assertProductWithoutId($expected, $actual);
    }

    private function assertProductWithoutId(Product $expected, Product $actual)
    {
        $this->assertEquals($expected->getName(), $actual->getName());
        $this->assertEquals($expected->getDescription(), $actual->getDescription());
        $this->assertEquals($expected->getImage()->getBinary(), $actual->getImage()->getBinary());
    }

    private function createDefaultProduct($path = 'Mobile/Samsung'): Product
    {
        $name = 'Samsung Galaxy S7 - ' . uniqid();
        $description = 'Some description - ' . uniqid();
        $category = new Category(null, PathBuilder::createByPath($path));
        return $product = ProductBuilder::instance()
            ->setName($name)
            ->setDescription($description)
            ->setPrice(12)
            ->setCategory($category)
            ->setImage(ImageBuilder::instance()->setBinary($this->getSomePngBinary())->build())
            ->setImages($this->createDefaultImages(5))
            ->build();
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

    private function getSomePngBinary()
    {
        return file_get_contents('./web/images/no-product.jpg');
    }

}