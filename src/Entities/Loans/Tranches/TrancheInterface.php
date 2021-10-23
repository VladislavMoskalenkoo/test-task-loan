<?php

namespace Src\Entities\Loans\Tranches;

use Src\Entities\Investors\Investor;
use Src\Entities\Investors\Investments\InvestmentInterface;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\InterestRates\AbstractInterestRate;
use Src\Entities\Loans\Tranches\Limits\TrancheLimit;
use Src\Entities\Wallets\Currencies\Currency;
use Src\Exceptions\Loan\LoanAlreadyBoundException;
use Src\Exceptions\Limit\LimitExceededException;

interface TrancheInterface
{
    /**
     * Get the tranche name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get currency.
     *
     * @return Currency
     */
    public function getCurrency(): Currency;

    /**
     * Get the tranche limit.
     *
     * @return TrancheLimit
     */
    public function getLimit(): TrancheLimit;

    /**
     * Bind the loan.
     *
     * @throws LoanAlreadyBoundException
     */
    public function bindLoan(Loan $loan): self;

    /**
     * Invest.
     *
     * @throws LimitExceededException
     */
    public function invest(InvestmentInterface $investment): self;

    /**
     * Get the interest rate.
     *
     * @return AbstractInterestRate
     */
    public function getInterestRate(): AbstractInterestRate;

    /**
     * Get the investments made by the investor.
     *
     * @return InvestmentInterface[]
     */
    public function getInvestmentsByInvestor(Investor $investor): array;
}