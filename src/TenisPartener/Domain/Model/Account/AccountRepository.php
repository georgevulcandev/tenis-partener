<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use TenisPartener\Domain\Model\Common\EmailAddress;

interface AccountRepository
{
    public function save(Account $account):void;

    /**
     * @throws CouldNotFindAccount
     */
    public function getById(AccountId $accountId): Account;

    public function getByEmail(EmailAddress $emailAddress): ?Account;

    public function nextIdentity(): AccountId;
}