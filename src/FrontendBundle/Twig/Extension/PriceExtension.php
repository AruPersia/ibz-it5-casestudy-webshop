<?php

namespace FrontendBundle\Twig\Extension;

class PriceExtension extends \Twig_Extension
{

    private $currencyManager;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyManager = $currencyService->getCurrencyManager();
    }

    public function getFilters()
    {
        return [new \Twig_SimpleFilter('price', [$this, 'price'])];
    }

    public function price($value)
    {
        return sprintf('%s %d.-', $this->currencyManager->getOutput(), $value * $this->currencyManager->getRate());
    }

}