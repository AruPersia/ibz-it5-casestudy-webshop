<?php

namespace FrontendBundle\Model\Checkout;

class StepBuilder
{

    private $name;
    private $view;
    private $next;
    private $previous = null;

    private function __construct($name, $view)
    {
        $this->name = $name;
        $this->view = $view;
    }

    public static function instance($name, $view): StepBuilder
    {
        return new StepBuilder($name, $view);
    }

    public function create($name, $view): StepBuilder
    {
        $this->next = StepBuilder::instance($name, $view);
        $this->next->previous = $this;
        return $this->next;
    }

    public function build(): Step
    {
        return $this->doBuild($this)->getRoot();
    }

    private function doBuild(StepBuilder $stepBuilder = null)
    {
        if ($stepBuilder == null) {
            return null;
        }

        return new Step($stepBuilder->name, $stepBuilder->view, $this->doBuild($stepBuilder->previous));
    }

}