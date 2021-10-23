<?php

namespace Src\Entities\Loans\Tranches;

use Src\Entities\Investors\Investments\InvestmentInterface;
use Src\Entities\Investors\Investor;
use Src\Entities\Loans\Tranches\InterestRates\AbstractInterestRate;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\Limits\TrancheLimit;
use Src\Entities\Wallets\Currencies\Currency;
use Src\Exceptions\Loan\LoanAlreadyBoundException;
use Src\Exceptions\Tranche\TrancheInvestmentWrongCurrencyException;

class Tranche implements TrancheInterface
{
    /** @var string $name */
    private $name;

    /** @var TrancheLimit $limit */
    private $limit;

    /** @var Loan $loan */
    private $loan;

    /** @var AbstractInterestRate $interestRate */
    private $interestRate;

    /** @var InvestmentInterface[] $investments */
    private $investments = [];

    /**
     * Tranche constructor.
     *
     * @param string $name
     * @param TrancheLimit $limit
     * @param AbstractInterestRate $interestRate
     */
    public function __construct(string $name, TrancheLimit $limit, AbstractInterestRate $interestRate)
    {
        $this->name = $name;
        $this->limit = $limit;
        $this->interestRate = $interestRate;
    }

    /**
     * @inheritDoc
     * @throws TrancheInvestmentWrongCurrencyException
     */
    public function invest(InvestmentInterface $investment): TrancheInterface
    {
        if ($this->limit->getCurrency() !== $investment->getCurrency()) {
            throw new TrancheInvestmentWrongCurrencyException();
        }

        $this->limit->deduct($investment->getAmount());

        $this->investments[] = $investment;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getInvestmentsByInvestor(Investor $investor): array
    {
        $investments = [];
        foreach ($this->investments as $investment) {
            if ($investment->getInvestor() === $investor) {
                $investments[] = $investment;
            }
        }

        return $investments;
    }

    /**
     * @inheritDoc
     */
    public function bindLoan(Loan $loan): TrancheInterface
    {
        if ($this->loan !== null) {
            throw new LoanAlreadyBoundException();
        }

        $this->loan = $loan;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): Currency
    {
        return $this->limit->getCurrency();
    }

    /**
     * @inheritDoc
     */
    public function getLimit(): TrancheLimit
    {
        return $this->limit;
    }

    /**
     * @inheritDoc
     */
    public function getInterestRate(): AbstractInterestRate
    {
        return $this->interestRate;
    }
}