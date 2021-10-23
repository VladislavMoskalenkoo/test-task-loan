<?php

namespace Src\Entities\Investors\Investments;

use DateTime;
use Src\Entities\Investors\Investor;
use Src\Entities\Wallets\Currencies\Currency;

interface InvestmentInterface
{
    /**
     * Get the investment amount.
     *
     * @return float
     */
    public function getAmount(): float;


    /**
     * Get the investment currency.
     *
     * @return Currency
     */
    public function getCurrency(): Currency;

    /**
     * Get the investor.
     *
     * @return Investor
     */
    public function getInvestor(): Investor;

    /**
     * Get the investment date.
     *
     * @return DateTime
     */
    public function getDate(): DateTime;
}