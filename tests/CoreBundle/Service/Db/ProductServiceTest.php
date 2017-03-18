<?php

namespace Tests\CoreBundle\Service\Db;

use BackendBundle\Form\ProductData;
use CoreBundle\Model\Image;
use CoreBundle\Model\ImageBuilder;
use CoreBundle\Model\Product;
use Symfony\Component\HttpFoundation\File\File;
use Tests\CoreBundle\Boot\TestWithDb;

class ProductServiceTest extends TestWithDb
{

    public function testCreateProductShouldWorkProperly()
    {
        // given
        $productData = $this->createDefaultProduct();

        // when
        $product = $this->backendProductService()->create($productData);

        // then
        $this->assertEquals(1, $product->getId());
        $this->assertProductData($productData, $product);
    }

    public function testFindProductByIdShouldWorkProperly()
    {
        // given
        $product = $this->backendProductService()->create($this->createDefaultProduct());

        // when
        $foundedProduct = $this->backendProductService()->findById(1);

        // then
        $this->assertProduct($product, $foundedProduct);
    }

    public function testFindByCategoryPathShouldWorkProperly()
    {
        // given
        for ($i = 0; $i < 10; $i++) {
            $this->backendProductService()->create($this->createDefaultProduct('/Mobile/Samsung'));
            $this->backendProductService()->create($this->createDefaultProduct('/Mobile/Apple'));
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
        $product = $this->backendProductService()->create($this->createDefaultProduct());
        $images = $this->createDefaultImages(2);

        // when
        $updatedProduct = $this->backendProductService()->addImages($product->getId(), $images);

        // then
        $this->assertCount(5, $product->getImages());
        $this->assertCount(7, $updatedProduct->getImages());
        $this->assertProduct($this->backendProductService()->findById($product->getId()), $updatedProduct);
    }

    public function testDeleteImagesShouldWorkProperly()
    {
        // given
        $product = $this->backendProductService()->create($this->createDefaultProduct());
        $imageEntityIds = array();
        foreach ($product->getImages() as $images) {
            $imageEntityIds[] = $images->getId();
        }

        // when
        $updatedProduct = $this->backendProductService()->removeImages($product->getId(), $imageEntityIds);

        // then
        $this->assertCount(5, $product->getImages());
        $this->assertCount(0, $updatedProduct->getImages());
        $this->assertProduct($this->backendProductService()->findById($product->getId()), $updatedProduct);
    }

    private function assertProduct(Product $expected, Product $actual)
    {
        $this->assertEquals($expected->getId(), $actual->getId());
        $this->assertEquals($expected->getCategory(), $actual->getCategory());
        $this->assertEquals($expected->getName(), $actual->getName());
        $this->assertEquals($expected->getDescription(), $actual->getDescription());
        $this->assertEquals($expected->getPrice(), $actual->getPrice());
        $this->assertEquals($expected->getStockQuantity(), $actual->getStockQuantity());
        $this->assertEquals($expected->getImage()->getId(), $actual->getImage()->getId());
        $this->assertEquals($expected->getImage()->getBinary(), $actual->getImage()->getBinary());
        $this->assertEquals($expected->getImages(), $actual->getImages());
    }

    private function assertProductData(ProductData $expected, Product $actual)
    {
        $this->assertEquals($expected->getName(), $actual->getName());
        $this->assertEquals($expected->getDescription(), $actual->getDescription());
        $this->assertEquals(file_get_contents($expected->getImages()[0]->getRealPath()), $actual->getImage()->getBinary());
    }

    private function createDefaultProduct($path = 'Mobile/Samsung'): ProductData
    {
        return ProductData::instance()
            ->setName('Samsung Galaxy S7 - ' . uniqid())
            ->setDescription('Some description - ' . uniqid())
            ->setPrice(980)
            ->setStockQuantity(10)
            ->setCategoryPath($path)
            ->setImages($this->createImages('UE BOOM 2 red'));
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

    private function getSomePngBinary()
    {
        return file_get_contents('./web/images/no-product.jpg');
    }

}