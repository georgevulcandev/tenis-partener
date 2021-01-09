<?php
declare(strict_types=1);

namespace Test\Acceptance;

use Ramsey\Uuid\Uuid;
use TenisPartener\Domain\Model\Account\Account;
use TenisPartener\Domain\Model\Account\AccountId;
use TenisPartener\Domain\Model\Account\AccountRepository;
use TenisPartener\Domain\Model\Account\CouldNotFindAccount;
use TenisPartener\Domain\Model\Common\EmailAddress;

final class InMemoryAccountRepository implements AccountRepository
{
    /**
     * @var array<string,Account>
     */
    private array $accounts = [];

    public function save(Account $account): void
    {
        $this->accounts[$account->accountId()->asString()] = $account;
    }

    public function getById(AccountId $accountId): Account
    {
        if (! isset($this->accounts[$accountId->asString()])) {
            throw CouldNotFindAccount::withAccountId($accountId);
        }

        return $this->accounts[$accountId->asString()];
    }

    public function getByEmail(EmailAddress $emailAddress): ?Account
    {
        /** @var Account $account */
        foreach ($this->accounts as $account) {
            if ($account->email()->equals($emailAddress)) {
                return $account;
            }
        }

        return null;
    }

    public function nextIdentity(): AccountId
    {
        return AccountId::fromString(Uuid::uuid4()->toString());
    }

    public function findAll(): array
    {
        return $this->accounts;
    }
}