<?php
declare(strict_types=1);

namespace TenisPartener\Application\Account;

use TenisPartener\Domain\Model\Account\AccountId;
use TenisPartener\Domain\Model\Account\AccountType;

final class UpgradeAccount
{
    private string $accountId;
    private AccountType $newAccountType;
    private string $paymentId;

    public function __construct(string $accountId, AccountType $accountType, string $paymentId)
    {
        $this->accountId = $accountId;
        $this->newAccountType = $accountType;
        $this->paymentId = $paymentId;
    }

    public function accountId(): AccountId
    {
        return AccountId::fromString($this->accountId);
    }

    public function newType(): AccountType
    {
        return $this->newAccountType;
    }

    public function paymentId(): string
    {
        return $this->paymentId;
    }
}