<?php
declare(strict_types=1);

namespace TenisPartener\Application;

use TenisPartener\Application\Account\CreateAccount;
use TenisPartener\Application\Account\UpgradeAccount;
use TenisPartener\Domain\Model\Account\AccountId;

interface ApplicationInterface
{
    public function createAccount(CreateAccount $command): AccountId;
    public function validateAccount(AccountId $accountId): void;
    public function upgradeAccount(UpgradeAccount $upgradeAccount): void;
}