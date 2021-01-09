<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use Assert\Assert;

final class Password
{
    private const MIN_LENGTH = 5;
    private const MAX_LENGTH = 10;

    private string $password;
    private string $hash = '';

    private function __construct(string $password)
    {
        Assert::that($password)->string();
        Assert::that($password)->betweenLength(self::MIN_LENGTH, self::MAX_LENGTH);

        $this->password = $password;
    }

    public static function createFromPlainText(string $password): Password
    {
        return new self($password);
    }

    public function asString(): string
    {
        return $this->password;
    }

    public function hashPassword(string $algorithm = PASSWORD_DEFAULT, array $options = []) : string
    {
        return password_hash($this->password, $algorithm, $options);
    }

    public function shouldBeRehashed(string $algorithm = PASSWORD_DEFAULT, array $options = []) : bool
    {
        if ('' === $this->hash) {
            return true;
        }

        return password_needs_rehash($this->hash, $algorithm, $options);
    }

    public function matchesHash(string $hash) : bool
    {
        $this->hash = $hash;

        return password_verify($this->password, $this->hash);
    }
}