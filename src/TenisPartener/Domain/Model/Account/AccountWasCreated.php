<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

final class AccountWasCreated
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function account(): Account
    {
        return $this->account;
    }
}