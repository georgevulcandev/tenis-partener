<?php
declare(strict_types=1);

namespace TenisPartener\Infrastructure;

use PHPUnit\Framework\TestCase;
use TenisPartener\Domain\Model\Account\HashedPassword;
use TenisPartener\Domain\Model\Account\Password;

final class BcryptPasswordHashingTest extends TestCase
{
    /**
     * @test
     */
    public function should_make_new_hashed_password_instance(): void
    {
        $service = new BcryptPasswordHashing();

        $hashed = $service->hash(Password::createFromPlainText('password'));

        self::assertInstanceof(HashedPassword::class, $hashed);
    }
}