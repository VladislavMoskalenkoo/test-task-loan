<?php

namespace Src\Entities\Investors\Investments;

use DateTime;
use Src\Entities\Investors\Investor;
use Src\Entities\Wallets\Currencies\Currency;

class Investment implements InvestmentInterface
{
    /** @var Investor $investor */
    private $investor;

    /** @var Currency $currency */
    private $currency;

    /** @var float $amount */
    private $amount;

    /** @var DateTime $date */
    private $date;

    /**
     * Investment constructor.
     *
     * @param Investor $investor
     * @param Currency $currency
     * @param float $amount
     * @param DateTime|null $date
     */
    public function __construct(
        Investor $investor,
        Currency $currency,
        float $amount,
        DateTime $date = null
    ) {
        $this->investor = $investor;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->date = $date ?? new DateTime();
    }

    /**
     * @inheritDoc
     */
    public function getInvestor(): Investor
    {
        return $this->investor;
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @inheritDoc
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @inheritDoc
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}