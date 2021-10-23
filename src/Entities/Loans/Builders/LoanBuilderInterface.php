<?php
namespace Src\Entities\Loans\Builders;

use DateTime;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\TrancheInterface;

interface LoanBuilderInterface
{
    /**
     * Add loan start date and end date.
     *
     * @param DateTime $startsAt
     * @param DateTime $endsAt
     * @return LoanBuilderInterface
     */
    public function setTimeframe(DateTime $startsAt, DateTime $endsAt): self;

    /**
     * Add tranche.
     *
     * @param TrancheInterface $tranche
     * @return LoanBuilderInterface
     */
    public function addTranche(TrancheInterface $tranche): self;

    /**
     * Get loan.
     *
     * @return Loan
     */
    public function getLoan(): Loan;
}