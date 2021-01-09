<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use Assert\Assert;

final class HashedPassword
{
    private string $hash;

    private function __construct(string $hash)
    {
        Assert::that($hash)->string();

        $this->hash = $hash;
    }

    public static function createFromHashedString(string $hash): self
    {
        return new self($hash);
    }

    public function asString(): string
    {
        return $this->hash;
    }
}