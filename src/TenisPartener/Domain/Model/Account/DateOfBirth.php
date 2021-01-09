<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use Assert\Assert;
use DateTimeImmutable;
use InvalidArgumentException;
use Throwable;

class DateOfBirth
{
    private const DATE_FORMAT = 'Y-m-d';
    private string $date;

    private function __construct(string $date)
    {
        try {
            $dateTimeImmutable = DateTimeImmutable::createFromFormat(
                self::DATE_FORMAT,
                $date
            );
            if ($dateTimeImmutable === false) {
                throw new InvalidArgumentException(
                    'The provided date/time string did not match the expected format'
                );
            }
        } catch (Throwable $throwable) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid date/time format. Provided: %s, expected format: %s',
                    $date,
                    self::DATE_FORMAT
                ),
                0,
                $throwable
            );
        }

        $this->date = $date;
    }

    public static function fromString(string $date): self
    {
        return new self($date);
    }

    public function asString(): string
    {
        return $this->date;
    }

    public function age(DateTimeImmutable $currentTime): int
    {
        return $this->asPhpDateTime()->diff($currentTime)->y;
    }

    public function asPhpDateTime(): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            $this->date,
        );

        Assert::that($dateTime)->isInstanceOf(DateTimeImmutable::class);

        return $dateTime;
    }
}
