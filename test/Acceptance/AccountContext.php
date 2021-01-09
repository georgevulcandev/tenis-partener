<?php
declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Tester\Exception\PendingException;
use BehatExpectException\ExpectException;
use PHPUnit\Framework\Assert;
use RuntimeException;
use TenisPartener\Application\Account\AccountAlreadyExists;
use TenisPartener\Application\Account\CreateAccount;
use TenisPartener\Application\Account\UpgradeAccount;
use TenisPartener\Application\Email\AccountWasCreatedEmail;
use TenisPartener\Domain\Model\Account\AccountId;
use TenisPartener\Domain\Model\Account\AccountType;
use TenisPartener\Domain\Model\Account\AccountWasCreated;
use TenisPartener\Domain\Model\Account\CannotUpgradeAccount;
use TenisPartener\Domain\Model\Account\HashedPassword;
use TenisPartener\Domain\Model\Common\EmailAddress;

/**
 * Defines application features from the specific context.
 */
class AccountContext extends FeatureContext
{
    use ExpectException;

    private ?AccountId $accountId = null;

    /**
     * @Given I am new to the website
     */
    public function iAmNewToTheWebsite()
    {
        Assert::assertNull(
            $this->accountRepository()->getByEmail(
                EmailAddress::fromString('test@tenispartener.com')
            )
        );
    }

    /**
     * @When I create a new account
     * @Given I have created an account and is not valid yet
     * @Given There is already an account with email address :arg1
     * @Given I have a free account
     */
    public function iCreateANewAccount()
    {
        $this->accountId = $this->application()->createAccount(
            new CreateAccount(
                'test@tenispartener.com',
                'password',
                'first name',
                'last name',
                'title',
                '2000-10-01',
                'Timisoara',
                5,
                '0756123456'
            )
        );
    }

    /**
     * @Then I should receive a confirmation email
     */
    public function iShouldReceiveAConfirmationEmail()
    {
        Assert::assertNotNull($this->accountId);

//        foreach ($this->dispatchedEvents() as $event) {
//            if ($event instanceof AccountWasCreated
//                && $event->accountId()->asString() === $this->accountId->asString()) {
//                return;
//            }
//        }
//
//        throw new RuntimeException('Expected an AccountWasCreated event.');

        foreach ($this->serviceContainer()->mailer()->sentEmails() as $email) {
            if ($email instanceof AccountWasCreatedEmail) {
                return;
            }
        }

        throw new RuntimeException('Received no such email');
    }

    /**
     * @Then The account type is free
     * @Then The account is not valid
     */
    public function theAccpountIsNotValidAndAccountTypeIsFree()
    {
        $account = $this->serviceContainer()->accountRepository()->getById($this->accountId);

        Assert::assertEquals(AccountType::free(), $account->type());
        Assert::assertFalse($account->isValid());
    }

    /**
     * @When I click on the confirmation link
     */
    public function iClickOnTheConfirmationLink()
    {
        $this->serviceContainer()->application()->validateAccount($this->accountId);
    }

    /**
     * @Then My account is validated
     */
    public function myAccountIsValidated()
    {
        $account = $this->serviceContainer()->accountRepository()->getById($this->accountId);

        Assert::assertTrue($account->isValid());
    }

    /**
     * @Then The password must be hashed
     */
    public function thePasswordMustBeHashed()
    {
        $account = $this->serviceContainer()->accountRepository()->getById($this->accountId);
        Assert::assertInstanceOf(HashedPassword::class, $account->password());
    }

    /**
     * @When I try to create a new account using the same email address
     */
    public function iTryToCreateANewAccountUsingTheSameEmailAddress()
    {
        $this->clearEvents();

        try {
            $this->application()->createAccount(
                new CreateAccount(
                    'test@tenispartener.com',
                    'password',
                    'first name',
                    'last name',
                    'title',
                    '2000-10-01',
                    'Timisoara',
                    5,
                    '0756123456'
                )
            );
        } catch (AccountAlreadyExists $exception) {

        }
    }

    /**
     * @Then The account should not be created
     */
    public function theAccountShouldNotBeCreated()
    {
        foreach ($this->dispatchedEvents() as $event) {
            if ($event instanceof AccountWasCreated) {
                throw new RuntimeException('We did not expect an AccountWasCreated event to have been dispatched');
            }
        }
    }

    /**
     * @When I try to create a new account having less then :arg1 years old
     */
    public function iTryToCreateANewAccountHavingLessThenYearsOld($arg1)
    {
        $this->clearEvents();
        try {
            $this->application()->createAccount(
                new CreateAccount(
                    'test@tenispartener.com',
                    'password',
                    'first name',
                    'last name',
                    'title',
                    '2011-10-01',
                    'Timisoara',
                    5,
                    '0756123456'
                )
            );
        } catch (\InvalidArgumentException $exception){

        }
    }

    /**
     * @When I make a success payment to upgrade my account
     */
    public function iMakeASuccessPaymentToUpgradeMyAccount()
    {
        $this->application()->upgradeAccount(
            new UpgradeAccount(
                $this->accountId->asString(),
                AccountType::premium(),
                'sasasasasasasas21323224343'
            )
        );
    }

    /**
     * @Then Then my account is upgraded
     */
    public function thenMyAccountIsUpgraded()
    {
        $account = $this->serviceContainer()->accountRepository()->getById($this->accountId);
        Assert::assertTrue($account->type()->equals(AccountType::premium()));
    }

    /**
     * @Given I have a premium account
     */
    public function iHaveAPremiumAccount()
    {
        $this->accountId = $this->application()->createAccount(
            new CreateAccount(
                'test@tenispartener.com',
                'password',
                'first name',
                'last name',
                'title',
                '2000-10-01',
                'Timisoara',
                5,
                '0756123456'
            )
        );

        $this->application()->upgradeAccount(
            new UpgradeAccount(
                $this->accountId->asString(),
                AccountType::premium(),
                'sasasasasasasas21323224343'
            )
        );

    }

    /**
     * @When I want to upgrade my account
     */
    public function iWantToUpgradeMyAccount()
    {
        $this->shouldFail(function () {
            $this->application()->upgradeAccount(
                new UpgradeAccount(
                    $this->accountId->asString(),
                    AccountType::premium(),
                    'sasasasasasasas21323224343'
                )
            );
        });
    }

    /**
     * @Then I shouldn't be allowed to upgrade my account
     */
    public function iShouldntBeAllowedToUpgradeMyAccount()
    {
        $message = sprintf(
            'Cannot upgrade account from %s to %s',
            AccountType::premium()->asString(),
            AccountType::premium()->asString()
        );
        $this->assertCaughtExceptionMatches(CannotUpgradeAccount::class, $message);
    }

    /**
     * @Given I have a summer or premium account for the current year
     */
    public function iHaveASummerOrPremiumAccountForTheCurrentYear()
    {
        throw new PendingException();
    }

    /**
     * @When I access my account and the availability is expired
     */
    public function iAccessMyAccountAndTheAvailabilityIsExpired()
    {
        throw new PendingException();
    }

    /**
     * @Then My account is switch back to a free account
     */
    public function myAccountIsSwitchBackToAFreeAccount()
    {
        throw new PendingException();
    }
}
