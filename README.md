Goal:
Give investors a way to invest in a loan for them to earn a return (monthly interest payment).

Model
- Each of our loans has a start date and an end date.
- Each loan is split in multiple tranches.
- Each tranche has a different monthly interest percentage.
Also each tranche has a maximum amount available to invest. So once the maximum is
reached, further investments can't be made in that tranche.
- As an investor, I can invest in a tranche at any time if the loan it’s still open, the maximum
available amount was not reached and I have enough money in my virtual wallet.
- At the end of the month we need to calculate the interest each investor is due to be paid.

Scenario
- Given a loan (start 01/10/2015 end 15/11/2015).
- Given the loan has 2 tranches called A and B (3% and 6% monthly interest rate) each with
1,000 pounds amount available.

Given each investor has 1,000 pounds in his virtual wallet.
- As “Investor 1” I’d like to invest 1,000 pounds on the tranche “A” on 03/10/2015: “ok”.
- As “Investor 2” I’d like to invest 1 pound on the tranche “A” on 04/10/2015: “exception”.
- As “Investor 3” I’d like to invest 500 pounds on the tranche “B” on 10/10/2015: “ok”.
- As “Investor 4” I’d like to invest 1,100 pounds on the tranche “B” 25/10/2015: “exception”.
- On 01/11/2015 the system runs the interest calculation for the period 01/10/2015 -> 31/10/2015:
- “Investor 1” earns 28.06 pounds
- “Investor 3” earns 21.29 pounds

# Installation
1. Clone the repository
2. Run `composer-install` command to install dependencies
3. Run `phpunit` command to run tests