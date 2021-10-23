<?php

use PHPUnit\Framework\TestCase;
use Src\Entities\Investors\Builders\InvestorBuilder;
use Src\Entities\Investors\Investor;
use Src\Entities\Loans\Builders\LoanBuilder;
use Src\Entities\Loans\Loan;
use Src\Entities\Loans\Tranches\InterestRates\MonthlyInterestRate;
use Src\Entities\Loans\Tranches\Limits\TrancheLimit;
use Src\Entities\Loans\Tranches\Tranche;
use Src\Entities\Wallets\Currencies\PoundCurrency;
use Src\Entities\Wallets\VirtualWallet;
use Src\Exceptions\Currency\InvalidCurrencyClassException;
use Src\Exceptions\Investor\InvestorInsufficientFundsException;
use Src\Exceptions\Wallet\InvalidWalletClassException;
use Src\Exceptions\Limit\LimitExceededException;
use Src\Services\LoanInterestCalculatorService;

class LoanTest extends TestCase
{
    /** @var Loan $loan */
    protected static $loan;

    /** @var Investor $investor1 */
    protected static $investor1;

    /** @var Investor $investor2 */
    protected static $investor2;

    /** @var Investor $investor3 */
    protected static $investor3;

    /** @var Investor $investor4 */
    protected static $investor4;

    public static function setUpBeforeClass(): void
    {
        self::$loan = self::createLoan();
        self::$investor1 = self::createInvestor();
        self::$investor2 = self::createInvestor();
        self::$investor3 = self::createInvestor();
        self::$investor4 = self::createInvestor();
    }

    public function test_investor_1_invest_1000_on_trance_a()
    {
        self::$investor1->invest(
            self::$loan->getTranche('A'),
            1000,
            new DateTime('2015-10-03')
        );

        $this->assertSame(self::$loan->getTranche('A')->getLimit()->available(), 0.0);
    }

    public function test_investor_2_invest_1_on_trance_a()
    {
        $this->expectException(LimitExceededException::class);

        self::$investor2->invest(
            self::$loan->getTranche('A'),
            1,
            new DateTime('2015-10-04')
        );
    }

    public function test_investor_3_invest_500_on_trance_B()
    {
        self::$investor3->invest(
            self::$loan->getTranche('B'),
            500,
            new DateTime('2015-10-10')
        );

        $this->assertSame(self::$loan->getTranche('B')->getLimit()->available(), 500.0);
    }

    public function test_investor_4_invest_1100_on_trance_B()
    {
        $this->expectException(InvestorInsufficientFundsException::class);

        self::$investor4->invest(
            self::$loan->getTranche('B'),
            1100,
            new DateTime('2015-10-25')
        );
    }

    public function test_interest_calculation_investor_1()
    {
        $calculateFromDate = new DateTime('2015-10-01');
        $calculateToDate = new DateTime('2015-10-31');

        $loanInterestCalculatorService = new LoanInterestCalculatorService();
        $earned = $loanInterestCalculatorService->calculate(
            self::$investor1,
            self::$loan,
            $calculateFromDate,
            $calculateToDate
        );

        $this->assertSame($earned, 28.06);
    }

    public function test_interest_calculation_investor_3()
    {
        $calculateFromDate = new DateTime('2015-10-01');
        $calculateToDate = new DateTime('2015-10-31');

        $loanInterestCalculatorService = new LoanInterestCalculatorService();
        $earned = $loanInterestCalculatorService->calculate(
            self::$investor3,
            self::$loan,
            $calculateFromDate,
            $calculateToDate
        );

        $this->assertSame($earned, 21.29);
    }

    /**
     * Create loan.
     *
     * @return Loan
     */
    private static function createLoan(): Loan
    {
        $currency = new PoundCurrency();

        $trancheA = new Tranche(
            'A',
            new TrancheLimit($currency, 1000),
            new MonthlyInterestRate(0.03)
        );

        $trancheB = new Tranche(
            'B',
            new TrancheLimit($currency, 1000),
            new MonthlyInterestRate(0.06)
        );

        $startDate = new DateTime('2015-10-01');
        $endsDate = new DateTime('2015-11-15');

        $loanBuilder = new LoanBuilder();
        return $loanBuilder->setTimeframe($startDate, $endsDate)
            ->addTranche($trancheA)
            ->addTranche($trancheB)
            ->getLoan();
    }

    /**
     * Create investor.
     *
     * @return Investor
     *
     * @throws InvalidCurrencyClassException
     * @throws InvalidWalletClassException
     */
    private static function createInvestor(): Investor
    {
        return (new InvestorBuilder())->setWallet(
            VirtualWallet::class,
            PoundCurrency::class,
            1000
        )->getInvestor();
    }
}