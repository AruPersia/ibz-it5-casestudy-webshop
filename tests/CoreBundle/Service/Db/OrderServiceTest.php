<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\OrderLine;
use CoreBundle\Model\OrderLineBuilder;
use Tests\CoreBundle\Boot\WithDefaultData;

class OrderServiceTest extends WithDefaultData
{

    public function testCreateOrderShouldWorkProperly()
    {
        // given
        $customerId = 1;
        $orderLines = $this->createSomeOrderLines();

        // when
        $order = $this->orderService()->create($customerId, $orderLines);

        // then
        $this->assertNotNull($order);
        $this->assertEquals(1, $order->getId());
        $this->assertCount(5, $order->getOrderLines());
    }

    /**
     * @return OrderLine[]
     */
    private function createSomeOrderLines()
    {
        $orderLines = array();

        for ($i = 1; $i <= 5; $i++) {
            $orderLines[] = OrderLineBuilder::instance()
                ->setQuantity(7)
                ->setProduct($this->productService()->findById($i))
                ->build();
        }

        return $orderLines;
    }

}