<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use RuntimeException;
use TenisPartener\Domain\Model\Common\EmailAddress;

final class CouldNotFindAccount extends RuntimeException
{
    public static function withAccountId(AccountId $accountId): self
    {
        return new self(
            sprintf(
                'Could not find account with ID %s',
                $accountId->asString()
            )
        );
    }

    public static function withEmailAddress(EmailAddress $emailAddress): self
    {
        return new self(
            sprintf(
                'Could not find account with email address %s',
                $emailAddress->asString()
            )
        );
    }
}