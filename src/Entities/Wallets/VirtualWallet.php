<?php

namespace Src\Entities\Wallets;

use Src\Exceptions\Wallet\WalletInsufficientFundsException;

class VirtualWallet extends AbstractWallet
{
    /** @var float $amount */
    private $amount = 0.0;

    /**
     * @inheritDoc
     */
    public function credit(float $amount): WalletInterface
    {
        $this->amount += $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withdraw(float $amount): WalletInterface
    {
        if ($this->amount < $amount) {
            throw new WalletInsufficientFundsException();
        }

        $this->amount -= $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}