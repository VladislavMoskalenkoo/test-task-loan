<?php

namespace Src\Entities\Wallets;

use Src\Entities\Wallets\Currencies\Currency;

abstract class AbstractWallet implements WalletInterface
{
    /** @var Currency $currency */
    private $currency;

    /**
     * AbstractWallet constructor.
     *
     * @param Currency $currency
     */
    public function __construct(Currency $currency)
    {
        $this->setCurrency($currency);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * Set currency.
     *
     * @param Currency $currency
     * @return void
     */
    private function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }
}