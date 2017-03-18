<?php

namespace Tests\FrontendBundle\Model\Checkout;

use FrontendBundle\Model\Checkout\Step;
use FrontendBundle\Model\Checkout\StepBuilder;

class StepBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildStepShouldWorkProperly()
    {
        // when
        $step = StepBuilder::instance('a', 'view-a')
            ->create('b', 'view-b')
            ->create('c', 'view-c')
            ->build();

        // then
        $nextStep = $this->assertStep('a', 'view-a', $step);
        $nextStep = $this->assertStep('b', 'view-b', $nextStep);
        $nextStep = $this->assertStep('c', 'view-c', $nextStep);
        $this->assertNull($nextStep);
    }

    private function assertStep($name, $href, Step $step)
    {
        $this->assertEquals($name, $step->getName());
        $this->assertEquals($href, $step->getView());
        return $step->getNext();
    }

}