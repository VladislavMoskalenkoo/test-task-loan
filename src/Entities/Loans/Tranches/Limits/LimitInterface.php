<?php

namespace Src\Entities\Loans\Tranches\Limits;

interface LimitInterface
{
    /**
     * Get total limit value.
     *
     * @return float
     */
    public function total(): float;

    /**
     * Get amount available.
     *
     * @return float
     */
    public function available(): float;

    /**
     * Deduct from the available amount.
     *
     * @param float $amount
     * @return LimitInterface
     */
    public function deduct(float $amount): self;
}