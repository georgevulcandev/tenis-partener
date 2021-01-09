<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Service;

use TenisPartener\Domain\Model\Account\HashedPassword;
use TenisPartener\Domain\Model\Account\Password;

interface PasswordHashing
{
    public function hash(Password $password): HashedPassword;
}