<?php
namespace Src\Entities\Investors\Builders;

use Src\Entities\Investors\Investor;

interface InvestorBuilderInterface
{
    /**
     * Add wallet.
     *
     * @param string $walletClass
     * @param string $currencyClass
     * @param float $initialCreditsAmount
     * @return InvestorBuilderInterface
     */
    public function setWallet(string $walletClass, string $currencyClass, float $initialCreditsAmount = 0.0): self;

    /**
     * Get investor.
     *
     * @return Investor
     */
    public function getInvestor(): Investor;
}