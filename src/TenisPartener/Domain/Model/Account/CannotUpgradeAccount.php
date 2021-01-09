<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use RuntimeException;

final class CannotUpgradeAccount extends RuntimeException
{
    public function __construct(AccountType $fromAccountType, AccountType $toAccountType)
    {
        parent::__construct(
            sprintf(
                'Cannot upgrade account from %s to %s',
                $fromAccountType->asString(),
                $toAccountType->asString()
            )
        );
    }
}