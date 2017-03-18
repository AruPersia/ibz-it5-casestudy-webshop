<?php

namespace FrontendBundle\Model\Checkout;

class Step
{

    private $name;
    private $view;
    private $previous;
    private $next;
    private $attributes = array();

    public function __construct($name, $view, Step $previous = null)
    {
        $this->name = $name;
        $this->view = $view;
        $this->previous = $previous;

        if ($previous != null) {
            $this->previous->next = $this;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getView()
    {
        return $this->view;
    }

    public function hasPrevious()
    {
        return $this->previous != null;
    }

    /**
     * @return Step|null
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    public function hastNext()
    {
        return $this->next != null;
    }

    /**
     * @return Step|null
     */
    public function getNext()
    {
        return $this->next;
    }

    public function getRoot(): Step
    {
        $step = $this;
        while ($step->hasPrevious()) {
            $step = $step->getPrevious();
        }

        return $step;
    }

    /**
     * @return Step[]
     */
    public function getAllSteps()
    {
        $steps[] = $step = $this->getRoot();
        while ($step->hastNext()) {
            $steps[] = $step = $step->getNext();
        }

        return $steps;
    }

    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }

    public function setAttribute($name, $value): Step
    {
        $this->attributes[$name] = $value;
        return $this;
    }

}