<?php

namespace Src\Entities\Wallets;

use Src\Entities\Wallets\Currencies\Currency;
use Src\Exceptions\Wallet\WalletInsufficientFundsException;

interface WalletInterface
{
    /**
     * Credit funds to the wallet.
     *
     * @param float $amount
     * @return $this
     */
    public function credit(float $amount): self;

    /**
     * Withdraw funds from the wallet.
     *
     * @param float $amount
     * @return $this
     * @throws WalletInsufficientFundsException
     */
    public function withdraw(float $amount): self;

    /**
     * Get the total amount of funds in wallet.
     *
     * @return float
     */
    public function getAmount(): float;

    /**
     * Get currency.
     *
     * @return Currency
     */
    public function getCurrency(): Currency;
}