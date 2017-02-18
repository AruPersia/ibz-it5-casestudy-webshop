<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\CategoryBuilder;
use CoreBundle\Model\Image;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Model\Product;
use CoreBundle\Model\ProductBuilder;
use Tests\CoreBundle\Boot\KernelTestCaseWithDbSupport;

class ProductServiceTest extends KernelTestCaseWithDbSupport
{

    public function testCreateProductShouldWorkProperly()
    {
        // given
        $product = $this->createDefaultProduct();

        // when
        $createdProduct = $this->productService()->create($product);

        // then
        $this->assertEquals(1, $createdProduct->getId());
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
            $this->productService()->create($this->createDefaultProduct());
        }

        // when
        $pcProducts = $this->productService()->findByCategoryPath('PC');
        $componentProducts = $this->productService()->findByCategoryPath('PC/Components');

        // then
        $this->assertCount(0, $pcProducts);
        $this->assertCount(10, $componentProducts);
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

    private function createDefaultProduct(): Product
    {
        $name = 'Samsung Galaxy S7 - ' . uniqid();
        $description = 'Some description - ' . uniqid();
        return $product = ProductBuilder::instance()
            ->setName($name)
            ->setDescription($description)
            ->setPrice(12)
            ->setCategory(CategoryBuilder::instance()->setPath('PC/Components')->build())
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
        return file_get_contents('./web/bundles/framework/images/logo_symfony.png');
    }

}