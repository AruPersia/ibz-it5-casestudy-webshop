<?php

namespace Tests\CoreBundle\Service\Db;

use Tests\CoreBundle\Boot\WithDefaultData;

class OrderServiceTest extends WithDefaultData
{

    public function testCreateOrderShouldWorkProperly()
    {
        // given
        $customerId = 1;
        $productIds = [1, 2, 3, 4, 5];

        // when
        $order = $this->orderService()->create($customerId, $productIds);

        // then
        $this->assertNotNull($order);
        $this->assertCount(5, $order->getOrderLines());
    }

}