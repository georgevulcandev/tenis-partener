<?php
declare(strict_types=1);

namespace TenisPartener\Application\Account;

use RuntimeException;
use TenisPartener\Domain\Model\Common\EmailAddress;

final class AccountAlreadyExists extends RuntimeException
{
    public function __construct(EmailAddress $emailAddress)
    {
        parent::__construct(
            sprintf(
                'Account with email %s already exists',
                $emailAddress->asString()
            )
        );
    }
}