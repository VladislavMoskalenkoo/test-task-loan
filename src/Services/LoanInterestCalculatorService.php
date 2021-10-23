<?php

namespace Src\Services;

use DateTime;
use Src\Entities\Investors\Investments\InvestmentInterface;
use Src\Entities\Investors\Investor;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\InterestRates\AbstractInterestRate;
use Src\Entities\Loans\Tranches\TrancheInterface;

class LoanInterestCalculatorService
{
    /**
     * @param Investor $investor
     * @param Loan $loan
     * @param DateTime $fromDate
     * @param DateTime $toDate
     * @return float
     */
    public function calculate(Investor $investor, Loan $loan, DateTime $fromDate, DateTime $toDate): float
    {
        $tranches = $loan->getAllTranches();

        $totalProfit = 0;
        foreach ($tranches as $tranche) {
            $totalProfit += $this->tranceProfit(
                $investor,
                $tranche,
                $fromDate,
                min($toDate, $loan->getEndDate())
            );
        }

        return $totalProfit;
    }

    /**
     * @param Investor $investor
     * @param TrancheInterface $tranche
     * @param DateTime $fromDate
     * @param DateTime $toDate
     * @return float
     */
    private function tranceProfit(Investor $investor, TrancheInterface $tranche,
                                  DateTime $fromDate, DateTime $toDate): float
    {
        $investments = $tranche->getInvestmentsByInvestor($investor);
        $interestRate = $tranche->getInterestRate();

        $totalTrancheProfit = 0.0;
        foreach ($investments as $investment) {
            $totalTrancheProfit += $this->getInvestmentProfit($investment, $interestRate, $fromDate, $toDate);
        }

        return $totalTrancheProfit;
    }

    /**
     * @param InvestmentInterface $investment
     * @param AbstractInterestRate $interestRate
     * @param DateTime $fromDate
     * @param DateTime $toDate
     * @return float
     */
    private function getInvestmentProfit(InvestmentInterface $investment, AbstractInterestRate $interestRate,
                                         DateTime $fromDate, DateTime $toDate): float
    {
        $fromDate = max($fromDate, $investment->getDate());
        $numberOfDays = $toDate->diff($fromDate)->d;

        $profit = 0.0;
        $calculatingDate = $fromDate;
        for ($i = 0; $i <= $numberOfDays; $i++) {
            $numberOfDaysInMonth = date('t', $calculatingDate->getTimestamp());

            $profitPerMonth = $investment->getAmount() * $interestRate->getRate();
            $profitPerDay = $profitPerMonth / $numberOfDaysInMonth;

            $profit += $profitPerDay;

            // Add one day
            $calculatingDate->add(new \DateInterval('P1D'));
        }

        return round($profit, 2);
    }


}