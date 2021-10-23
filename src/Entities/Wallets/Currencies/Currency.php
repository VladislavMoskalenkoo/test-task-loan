<?php

namespace Src\Entities\Wallets\Currencies;

abstract class Currency
{
    /**
     * Get currency code.
     *
     * @return string
     */
    abstract public function getCode(): string;
}