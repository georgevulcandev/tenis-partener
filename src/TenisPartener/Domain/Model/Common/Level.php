<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Common;

use Assert\Assert;
use InvalidArgumentException;

final class Level
{
    private const MIN_LEVEL = 4;
    private const MAX_LEVEL = 9;
    private int $level;

    public function __construct(int $level)
    {
        Assert::that($level)->integer('Level must be specified as int');

        if ($level < self::MIN_LEVEL || $level > self::MAX_LEVEL) {
            throw new InvalidArgumentException(
                sprintf(
                    'Level must be between %d and %d',
                    self::MIN_LEVEL,
                    self::MAX_LEVEL
                )
            );
        }

        $this->level = $level;
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public function asInt(): int
    {
        return $this->level;
    }
}