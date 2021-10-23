<?php

namespace Src\Entities\Loans\Builders;

use DateTime;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\TrancheInterface;

class LoanBuilder implements LoanBuilderInterface
{
    /** @var DateTime $startsAt */
    private $startsAt;

    /** @var DateTime $endsAt */
    private $endsAt;

    /** @var TrancheInterface[] $tranches */
    private $tranches;

    /**
     * @inheritDoc
     */
    public function setTimeframe(DateTime $startsAt, DateTime $endsAt): LoanBuilderInterface
    {
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addTranche(TrancheInterface $tranche): LoanBuilderInterface
    {
        $this->tranches[] = $tranche;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLoan(): Loan
    {
        $loan = new Loan($this->tranches, $this->startsAt, $this->endsAt);

        $this->reset();

        return $loan;
    }

    /**
     * Reset the builder state.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->startsAt = null;
        $this->endsAt = null;
        $this->tranches = [];
    }
}