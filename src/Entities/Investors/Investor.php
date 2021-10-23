<?php

namespace Src\Entities\Investors;

use DateTime;
use Exception;
use Src\Entities\Investors\Investments\Investment;
use Src\Entities\Loans\Tranches\TrancheInterface;
use Src\Exceptions\Investor\InvestorInsufficientFundsException;
use Src\Exceptions\Investor\InvestorMissingWalletException;
use Src\Entities\Wallets\WalletInterface;
use Src\Exceptions\Limit\LimitExceededException;
use Src\Exceptions\Wallet\WalletInsufficientFundsException;

class Investor
{
    /** @var WalletInterface $wallet */
    private $wallet;

    /**
     * Get investor wallet.
     *
     * @throws InvestorMissingWalletException
     */
    public function getWallet(): WalletInterface
    {
        if (!$this->wallet) {
            throw new InvestorMissingWalletException();
        }

        return $this->wallet;
    }

    /**
     * Set wallet.
     *
     * @param WalletInterface $wallet
     * @return $this
     */
    public function setWallet(WalletInterface $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @throws InvestorMissingWalletException
     * @throws InvestorInsufficientFundsException
     * @throws Exception
     */
    public function invest(TrancheInterface $tranche, float $amount, DateTime $customDate = null): self
    {
        $wallet = $this->getWallet();

        try {
            $wallet->withdraw($amount);

            $investmentDate = $customDate ?? new DateTime();
            $investment = new Investment(
                $this,
                $tranche->getCurrency(),
                $amount,
                $investmentDate
            );

            $tranche->invest($investment);
        } catch (WalletInsufficientFundsException $e) {
            throw new InvestorInsufficientFundsException();
        } catch (Exception $e) {
            // Refund money to wallet
            $wallet->credit($amount);
            throw $e;
        }

        return $this;
    }
}