<?php

namespace Tests\CoreBundle\Service\Db;

use Tests\CoreBundle\Boot\WithDefaultData;

class OrderServiceTest extends WithDefaultData
{

    public function testCreateCategoryShouldWorkProperly()
    {
        // given
        $customerId = 1;
        $productIds = [1, 2];

        // when
        $this->orderService()->create($customerId, $productIds);

        // then
        $result = $this->orderService()->findByCustomerId(1);
        $this->assertCount(1, $result);
        $this->assertCount(2, $result[0]->getOrderLines());
    }

}