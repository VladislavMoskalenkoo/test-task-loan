<?php

namespace Src\Entities\Investors\Builders;

use Src\Entities\Investors\Investor;
use Src\Entities\Wallets\Currencies\Currency;
use Src\Entities\Wallets\WalletInterface;
use Src\Exceptions\Currency\InvalidCurrencyClassException;
use Src\Exceptions\Wallet\InvalidWalletClassException;

class InvestorBuilder implements InvestorBuilderInterface
{
    /** @var Investor $investor */
    private $investor;

    /**
     * InvestorBuilder constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @inheritDoc
     * @throws InvalidWalletClassException
     * @throws InvalidCurrencyClassException
     */
    public function setWallet(string $walletClass, string $currencyClass, float $initialCreditsAmount = 0.0): InvestorBuilderInterface
    {
        if (!class_exists($currencyClass)) {
            throw new InvalidCurrencyClassException($currencyClass);
        }

        if (!class_exists($walletClass)) {
            throw new InvalidWalletClassException($walletClass);
        }

        /** @var Currency $currency */
        $currency = new $currencyClass();

        /** @var WalletInterface $wallet */
        $wallet = new $walletClass($currency);
        $wallet->credit($initialCreditsAmount);

        $this->investor->setWallet($wallet);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getInvestor(): Investor
    {
        $result = $this->investor;
        $this->reset();

        return $result;
    }

    /**
     * Reset the builder state.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->investor = new Investor();
    }
}