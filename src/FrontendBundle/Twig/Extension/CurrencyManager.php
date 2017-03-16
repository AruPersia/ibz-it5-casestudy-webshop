<?php

namespace FrontendBundle\Twig\Extension;

class CurrencyManager
{

    private $base;
    private $date;
    private $rates;
    private $output;

    public function __construct($jsonData)
    {
        $data = json_decode($jsonData, true);
        $this->base = $data['base'];
        $this->date = $data['date'];
        $this->rates = array_merge(['CHF' => 1], $data['rates']);
        $this->output = 'CHF';

        ksort($this->rates);
    }

    public function getBase()
    {
        return $this->base;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getRates()
    {
        return $this->rates;
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