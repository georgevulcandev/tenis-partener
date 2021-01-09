<?php
declare(strict_types=1);

namespace TenisPartener\Infrastructure;

use TenisPartener\Domain\Model\Account\HashedPassword;
use TenisPartener\Domain\Model\Account\Password;
use TenisPartener\Domain\Service\PasswordHashing;

final class BcryptPasswordHashing implements PasswordHashing
{
    private const ALGORITHM = PASSWORD_DEFAULT;
    private const OPTIONS = [];

    public function hash(Password $password): HashedPassword
    {
        return HashedPassword::createFromHashedString(
            password_hash(
                $password->asString(),
                self::ALGORITHM,
                self::OPTIONS
            )
        );
    }
}