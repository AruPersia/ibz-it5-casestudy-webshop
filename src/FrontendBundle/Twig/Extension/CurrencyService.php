<?php

namespace FrontendBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;

class CurrencyService
{

    const CURRENCY_SESSION_KEY = 'currency';

    private $session;
    private $currencyManager;

    public function __construct(RequestStack $requestStack)
    {
        if ($requestStack->getCurrentRequest() == null) {
            $this->currencyManager = $this->reload();
            return;
        }

        $this->session = $requestStack->getCurrentRequest()->getSession();
        $this->currencyManager = $this->loadOrCreateCurrencyManager();
        if ($this->currencyManager->getUpdated() != (new \DateTime())->format('Y-m-d')) {
            $this->currencyManager = $this->reload();
        }
    }

    public function getCurrencyManager(): CurrencyManager
    {
        return $this->currencyManager;
    }

    public function setOutputCurrency($output)
    {
        $this->currencyManager->setOutput($output);
        $this->saveInToSession($this->currencyManager);
    }

    private function loadOrCreateCurrencyManager(): CurrencyManager
    {
        if ($this->session->has(self::CURRENCY_SESSION_KEY)) {
            return $this->loadFromSession();
        }
        return $this->saveInToSession($this->reload());
    }

    private function loadFromSession(): CurrencyManager
    {
        return $this->session->get(self::CURRENCY_SESSION_KEY);
    }

    private function saveInToSession(CurrencyManager $currencyManager): CurrencyManager
    {
        $this->session->set(self::CURRENCY_SESSION_KEY, $currencyManager);
        return $currencyManager;
    }

    private function reload(): CurrencyManager
    {
        $jsonData = file_get_contents('http://api.fixer.io/latest?base=CHF&symbols=EUR,GBP,USD,JPY');
        return new CurrencyManager($jsonData);
    }

}