<?php

namespace Src\Entities\Loans;

use DateTime;
use Src\Entities\Loans\Tranches\TrancheInterface;
use Src\Exceptions\Tranche\TrancheNotFoundException;
use Src\Exceptions\Loan\LoanAlreadyBoundException;

class Loan
{
    /** @var TrancheInterface[] $tranches */
    private $tranches = [];

    /** @var DateTime $startsAt */
    private $startsAt;

    /** @var DateTime $endsAt */
    private $endsAt;

    /**
     * Loan constructor.
     *
     * @param TrancheInterface[] $tranches
     * @param DateTime $startsAt
     * @param DateTime $endsAt
     * @throws LoanAlreadyBoundException
     */
    public function __construct(array $tranches, DateTime $startsAt, DateTime $endsAt)
    {
        foreach ($tranches as $tranche) {
            if ($tranche instanceof TrancheInterface) {
                $this->bindTranche($tranche);
            }
        }

        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }

    /**
     * Get tranche by name.
     *
     * @throws TrancheNotFoundException
     */
    public function getTranche(string $name): TrancheInterface
    {
        foreach ($this->tranches as $tranche) {
            if ($tranche->getName() === $name) {
                return $tranche;
            }
        }

        throw new TrancheNotFoundException();
    }

    /**
     * Get all tranches.
     *
     * @return TrancheInterface[]
     */
    public function getAllTranches(): array
    {
        return $this->tranches;
    }

    /**
     * Get loan start date.
     *
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startsAt;
    }

    /**
     * Get loan end date.
     *
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endsAt;
    }

    /**
     * Bind tranche.
     *
     * @param TrancheInterface $tranche
     * @return void
     * @throws LoanAlreadyBoundException
     */
    private function bindTranche(TrancheInterface $tranche): void
    {
        $this->tranches[] = $tranche->bindLoan($this);
    }
}