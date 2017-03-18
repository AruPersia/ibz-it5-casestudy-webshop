<?php

namespace Tests\CoreBundle\Service\Db;

use CoreBundle\Model\Address;
use CoreBundle\Model\AddressBuilder;
use CoreBundle\Model\OrderLine;
use CoreBundle\Model\OrderLineBuilder;
use Tests\CoreBundle\Boot\TestWithDbDefaultData;

class OrderServiceTest extends TestWithDbDefaultData
{

    public function testCreateOrderShouldWorkProperly()
    {
        // given
        $customerId = 1;
        $deliveryAddress = AddressBuilder::instance()
            ->setStreet('Talackerstrasse')
            ->setHouseNumber('45h')
            ->setPostCode('3604')
            ->setCity('Thun')
            ->build();

        $customer = $this->customerService()->findById($customerId);

        $orderLines = $this->createSomeOrderLines();

        // when
        $order = $this->frontendOrderService()->create($customerId, $deliveryAddress, $orderLines);

        // then
        $this->assertNotNull($order);
        $this->assertEquals(5, $order->getId());
        $this->assertEquals($customer->getAddress(), $order->getCustomer()->getAddress());
        $this->assertAddress($deliveryAddress, $order->getDeliveryAddress());
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

    private function assertAddress(Address $expected, Address $actual)
    {
        $this->assertEquals($expected->getStreet(), $actual->getStreet());
        $this->assertEquals($expected->getHouseNumber(), $actual->getHouseNumber());
        $this->assertEquals($expected->getPostCode(), $actual->getPostCode());
        $this->assertEquals($expected->getCity(), $actual->getCity());
    }

}