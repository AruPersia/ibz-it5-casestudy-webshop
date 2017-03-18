<?php

namespace Tests\BackendBundle\Service\Db;

use BackendBundle\Model\Reorder;
use Tests\CoreBundle\Boot\TestWithDbDefaultData;

class ReorderServiceTest extends TestWithDbDefaultData
{

    public function testCreateReorderShouldWorkProperly()
    {
        // given
        $today = new \DateTime();
        $product = $this->productService()->findById(1);
        $expected = new Reorder(22, $product, 10, $today, $today, null);

        // when
        $reorder = $this->backendReorderService()->create(1, 10, $today, $today);

        // then
        $this->assertReorder($expected, $reorder);
    }

    public function testFindUpdateDeliveredDateShouldWorkProperly()
    {
        // given
        $reorders = $this->backendReorderService()->findPending();
        $reorder = $reorders[0];

        // when
        $updatedReorder = $this->backendReorderService()->updateDeliveredDate($reorder->getId());

        // then
        $this->assertEquals($reorder->getId(), $updatedReorder->getId());
        $this->assertNull($reorder->getDeliveredDate());
        $this->assertNotNull($updatedReorder->getDeliveredDate());
    }

    public function testFindDeliveredReorderShouldWorkProperly()
    {
        // when
        $reorders1 = $this->backendReorderService()->findDelivered(999);
        $reorders2 = $this->backendReorderService()->findDelivered(2);

        // then
        $this->assertCount(10, $reorders1);
        $this->assertCount(2, $reorders2);
    }

    public function testFindPendingReorderShouldWorkProperly()
    {
        // when
        $reorders = $this->backendReorderService()->findPending();

        // then
        $this->assertCount(11, $reorders);
    }

    private function assertReorder(Reorder $expected, Reorder $actual)
    {
        $this->assertEquals($expected, $actual);
    }

}