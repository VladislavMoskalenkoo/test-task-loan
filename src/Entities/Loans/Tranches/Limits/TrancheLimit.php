<?php

namespace Src\Entities\Loans\Tranches\Limits;

use Src\Entities\Wallets\Currencies\Currency;
use Src\Exceptions\Limit\LimitExceededException;

class TrancheLimit implements LimitInterface
{
    private $total;
    private $available;
    private $currency;

    public function __construct(Currency $currency, float $limit)
    {
        $this->currency = $currency;
        $this->total = $limit;
        $this->available = $limit;
    }

    /**
     * @inheritDoc
     */
    public function total(): float
    {
        return $this->total;
    }

    /**
     * @inheritDoc
     */
    public function available(): float
    {
        return $this->available;
    }

    /**
     * @inheritDoc
     * @throws LimitExceededException
     */
    public function deduct(float $amount): LimitInterface
    {
        if ($this->available < $amount) {
            throw new LimitExceededException();
        }

        $this->available -= $amount;

        return $this;
    }

    /**
     * Get limit currency.
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}