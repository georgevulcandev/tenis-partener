<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use Assert\Assert;
use DateTimeImmutable;
use TenisPartener\Domain\Model\Common\EmailAddress;
use TenisPartener\Domain\Model\Common\Level;
use TenisPartener\Domain\Model\Common\Title;

final class Account
{
    private array $events = [];

    private AccountId $id;
    private EmailAddress $emailAddress;
    private HashedPassword $password;
    private string $firstName;
    private string $lastName;
    private Title  $title;
    private DateOfBirth $dateOfBirth;
    private string $city;
    private Level $level;
    private string $phoneNumber;
    private bool $valid;
    private DateTimeImmutable $createdAt;
    private AccountType $type;

    private function __construct()
    {
    }

    public static function create(
        AccountId $accountId,
        EmailAddress $emailAddress,
        HashedPassword $hashedPassword,
        string $firstName,
        string $lastName,
        Title $title,
        CanCreateAccountDateOfBirth $canCreateAccountDateOfBirth,
        string $city,
        Level $level,
        string $phoneNumber,
        DateTimeImmutable $createdAt
    ) : self {
        $account = new self();

        Assert::that($firstName)->notEmpty('The first name must not be empty');
        Assert::that($lastName)->notEmpty('The last name must not be empty');
        Assert::that($city)->notEmpty('City must not be empty');
        Assert::that($phoneNumber)->notEmpty('Phone number must not be empty');

        $account->id = $accountId;
        $account->emailAddress = $emailAddress;
        $account->password = $hashedPassword;
        $account->firstName = $firstName;
        $account->lastName = $lastName;
        $account->title = $title;
        $account->dateOfBirth = $canCreateAccountDateOfBirth->dateOfBirth();
        $account->city = $city;
        $account->level = $level;
        $account->phoneNumber = $phoneNumber;
        $account->createdAt = $createdAt;

        $account->type = AccountType::free();
        $account->valid = false;

        $account->events[] = new AccountWasCreated($account);

        return $account;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    public function accountId(): AccountId
    {
        return $this->id;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }

    public function email(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function validate(): void
    {
        if (! $this->valid) {
            $this->valid = true;
        }
    }

    public function type(): AccountType
    {
        return $this->type;
    }

    public function upgradeTo(AccountType $newAccountType): void
    {
        if (! $this->type->canBeUpgradedTo($newAccountType)) {
            throw new CannotUpgradeAccount($this->type, $newAccountType);
        }

        $this->type = $newAccountType;
    }
}