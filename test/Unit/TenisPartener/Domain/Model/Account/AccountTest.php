<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use DateTimeImmutable;
use InvalidArgumentException;
use TenisPartener\Domain\Common\EntityTestCase;

final class AccountTest extends EntityTestCase
{
    use AccountFactoryMethods;
    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        $accountId = $this->anAccountId();
        $emailAddress = $this->anEmailAddress();
        $password = $this->aHashedPassword();
        $firstName = $this->aFirstName();
        $lastName = $this->aLastName();
        $title = $this->aTitle();
        $dateOfBirth = $this->aCanCreateAccountDateOfBirth();
        $city = $this->aCity();
        $level = $this->aLevel();
        $phoneNumber = $this->aPhoneNumber();

        $account = Account::create(
            $accountId,
            $emailAddress,
            $password,
            $firstName,
            $lastName,
            $title,
            $dateOfBirth,
            $city,
            $level,
            $phoneNumber,
            new DateTimeImmutable()
        );

        //var_dump($account);
        self::assertArrayContainsObjectOfType(AccountWasCreated::class, $account->releaseEvents());
        self::assertEquals($accountId, $account->accountId());
        self::assertEquals(false, $account->isValid());
    }

    /**
     * @test
     */
    public function it_can_be_validated(): void
    {
        $account = $this->anAccount();

        $account->validate();
        self::assertEquals(true, $account->isValid());
    }

    /**
     * @test
     */
    public function the_minimum_age_must_be_11(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Age must be greater then 11.');

        $accountId = $this->anAccountId();
        $emailAddress = $this->anEmailAddress();
        $password = $this->aHashedPassword();
        $firstName = $this->aFirstName();
        $lastName = $this->aLastName();
        $title = $this->aTitle();
        $dateOfBirth = $this->aCannotCreateAccountDateOfBirth();
        $city = $this->aCity();
        $level = $this->aLevel();
        $phoneNumber = $this->aPhoneNumber();

        $account = Account::create(
            $accountId,
            $emailAddress,
            $password,
            $firstName,
            $lastName,
            $title,
            $dateOfBirth,
            $city,
            $level,
            $phoneNumber,
            $this->currentTime()
        );
    }

    /**
     * @test
     */
    public function password_must_be_stored_hashed(): void
    {
        $account = $this->anAccount();

        self::assertInstanceOf(HashedPassword::class, $account->password());
    }
}