<?php
declare(strict_types=1);

namespace TenisPartener\Application\Email;

use TenisPartener\Domain\Model\Account\Account;

final class AccountWasCreatedEmail implements Email
{
    private Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function recipient(): string
    {
        return $this->account->email()->asString();
    }

    public function subject(): string
    {
        // TODO: Implement subject() method.
    }

    public function template(): string
    {
        // TODO: Implement template() method.
    }

    public function account(): Account
    {
        return $this->account;
    }
}