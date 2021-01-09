<?php
declare(strict_types=1);

namespace TenisPartener\Application;

use TenisPartener\Application\Account\AccountAlreadyExists;
use TenisPartener\Application\Account\CreateAccount;
use TenisPartener\Application\Account\UpgradeAccount;
use TenisPartener\Domain\Model\Account\Account;
use TenisPartener\Domain\Model\Account\AccountId;
use TenisPartener\Domain\Model\Account\AccountRepository;
use TenisPartener\Domain\Model\Account\CanCreateAccountDateOfBirth;
use TenisPartener\Domain\Model\Account\CouldNotFindAccount;
use TenisPartener\Domain\Service\PasswordHashing;

final class Application implements ApplicationInterface
{
    private AccountRepository $accountRepository;
    private PasswordHashing $passwordHashing;
    private Clock $clock;
    private EventDispatcher $eventDispatcher;

    public function __construct(
        AccountRepository $accountRepository,
        PasswordHashing $passwordHashing,
        Clock $clock,
        EventDispatcher $eventDispatcher
    ) {
        $this->accountRepository = $accountRepository;
        $this->passwordHashing = $passwordHashing;
        $this->clock = $clock;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createAccount(CreateAccount $command): AccountId
    {
        $account = $this->accountRepository->getByEmail($command->emailAddress());
        if (null !== $account) {
            throw new AccountAlreadyExists($command->emailAddress());
        }

        $account = Account::create(
            $this->accountRepository->nextIdentity(),
            $command->emailAddress(),
            $this->passwordHashing->hash($command->password()),
            $command->firstName(),
            $command->lastName(),
            $command->title(),
            CanCreateAccountDateOfBirth::fromInputData($command->dateOfBirth(), $this->clock->currentTime()),
            //$command->dateOfBirth(),
            $command->city(),
            $command->level(),
            $command->phoneNumber(),
            $this->clock->currentTime()
        );

        $this->accountRepository->save($account);

        $this->eventDispatcher->dispatchAll($account->releaseEvents());

        return $account->accountId();
    }

    public function validateAccount(AccountId $accountId): void
    {
        try {
            $account = $this->accountRepository->getById($accountId);
        } catch (CouldNotFindAccount $exception) {
            return;
        }

        $account->validate();

        $this->accountRepository->save($account);
    }

    public function upgradeAccount(UpgradeAccount $upgradeAccount): void
    {
        try {
            $account = $this->accountRepository->getById($upgradeAccount->accountId());
        } catch (CouldNotFindAccount $exception) {
            return;
        }

        $account->upgradeTo($upgradeAccount->newType());

        $this->accountRepository->save($account);
    }
}