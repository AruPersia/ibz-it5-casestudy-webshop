<?php

namespace Tests\CoreBundle\Service\Db;

use Tests\CoreBundle\Boot\TestWithDbDefaultData;

class StockServiceTest extends TestWithDbDefaultData
{

    public function testAddProductToStockShouldWorkProperly()
    {
        // given
        $product = $this->productService()->findById(1);

        // when
        $stockSize = $this->stockService()->addProduct($product, 10);

        // then
        $this->assertEquals(10, $stockSize);
    }

    public function testUpdateStockShouldWorkProperly()
    {
        // given
        $product = $this->productService()->findById(1);
        $fistStockSize = $this->stockService()->addProduct($product, 7);

        // when
        $stockSize = $this->stockService()->addProduct($product, 9);

        // then
        $this->assertEquals(7, $fistStockSize);
        $this->assertEquals(16, $stockSize);
    }

}