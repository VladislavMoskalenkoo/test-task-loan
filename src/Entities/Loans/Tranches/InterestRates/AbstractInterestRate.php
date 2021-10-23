<?php

namespace Src\Entities\Loans\Tranches\InterestRates;

abstract class AbstractInterestRate
{
    /** @var float $rate */
    private $rate;

    public function __construct(float $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the interest rate period.
     *
     * @return string
     */
    abstract public function getPeriod(): string;

    /**
     * Get interest rate value.
     *
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
}