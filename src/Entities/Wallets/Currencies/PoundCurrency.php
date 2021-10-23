<?php

namespace Src\Entities\Wallets\Currencies;

class PoundCurrency extends Currency
{
    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return 'GBP';
    }
}