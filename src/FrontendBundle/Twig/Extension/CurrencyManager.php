<?php

namespace FrontendBundle\Twig\Extension;

class CurrencyManager
{

    private $base;
    private $rates;
    private $updated;
    private $output;

    public function __construct($jsonData)
    {
        $data = json_decode($jsonData, true);
        $this->base = $data['base'];
        $this->rates = array_merge(['CHF' => 1], $data['rates']);
        $this->updated = (new \DateTime())->format('Y-m-d');
        $this->output = 'CHF';
        ksort($this->rates);
    }

    public function getBase()
    {
        return $this->base;
    }

    public function getRates()
    {
        return $this->rates;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function getRate()
    {
        return $this->rates[$this->output];
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

}