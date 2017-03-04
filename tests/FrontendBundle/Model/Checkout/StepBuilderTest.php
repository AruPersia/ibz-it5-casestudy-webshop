<?php

namespace Tests\FrontendBundle\Model\Checkout;

use FrontendBundle\Model\Checkout\Step;
use FrontendBundle\Model\Checkout\StepBuilder;

class StepBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildStepShouldWorkProperly()
    {
        // when
        $step = StepBuilder::instance('a', 'a-href')
            ->create('b', 'b-href')
            ->create('c', 'c-href')
            ->build();

        // then
        $nextStep = $this->assertStep('a', 'a-href', $step);
        $nextStep = $this->assertStep('b', 'b-href', $nextStep);
        $nextStep = $this->assertStep('c', 'c-href', $nextStep);
        $this->assertNull($nextStep);
    }

    private function assertStep($name, $href, Step $step)
    {
        $this->assertEquals($name, $step->getName());
        $this->assertEquals($href, $step->getHref());
        return $step->getNext();
    }

}