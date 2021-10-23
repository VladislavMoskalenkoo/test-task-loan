<?php

namespace Src\Entities\Loans\Tranches\InterestRates;

class MonthlyInterestRate extends AbstractInterestRate
{
    public const PERIOD_MONTHLY = 'monthly';

    /**
     * @inheritDoc
     */
    public function getPeriod(): string
    {
        return self::PERIOD_MONTHLY;
    }
}