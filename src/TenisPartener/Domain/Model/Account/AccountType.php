<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

final class AccountType
{
    private const FREE = 'free';
    private const SUMMER = 'summer';
    private const PREMIUM = 'premium';

    private const ALLOWED_TYPES = [
        self::FREE,
        self::SUMMER,
        self::PREMIUM,
    ];

    private string $accountType;

    private function __construct(string $accountType)
    {
        $this->accountType = $accountType;
    }

    public static function free(): self
    {
        return new self(self::FREE);
    }

    public static function summer(): self
    {
        return new self(self::SUMMER);
    }

    public static function premium(): self
    {
        return new self(self::PREMIUM);
    }

    public function asString(): string
    {
        return $this->accountType;
    }

    /**
     * @throws InvalidAccountType
     */
    public static function fromString(string $type): self
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw InvalidAccountType::forType($type);
        }

        return new self($type);
    }

    public function equals(AccountType $other): bool
    {
        return $this->accountType === $other->asString();
    }

    public function canBeUpgradedTo(AccountType $other): bool
    {
        if ($this->accountType === self::FREE &&
            ($other->accountType === self::SUMMER || $other->accountType === self::PREMIUM)) {
            return true;
        }

        if ($this->accountType === self::SUMMER && $other->accountType === self::PREMIUM) {
            return true;
        }

        return false;
    }

    //public function isAvailable(A)
}