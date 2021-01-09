<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Common;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;
use Throwable;

final class Date
{
    private const DATE_TIME_FORMAT = 'Y-m-d H:i';

    private string $dateTime;

    private function __construct(string $dateTime)
    {
        try {
            $dateTimeImmutable = DateTimeImmutable::createFromFormat(
                self::DATE_TIME_FORMAT,
                $dateTime
            );
            if ($dateTimeImmutable === false) {
                throw new InvalidArgumentException('The provided date/time string did not match the expected format');
            }
        } catch (Throwable $throwable) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid date/time format. Provided: %s, expected format: %s',
                    $dateTime,
                    self::DATE_TIME_FORMAT
                ),
                0,
                $throwable
            );
        }

        $this->dateTime = $dateTimeImmutable->format(self::DATE_TIME_FORMAT);
    }

    public static function fromString(string $dateTime): Date
    {
        return new self($dateTime);
    }

    public static function fromDateTimeImmutable(DateTimeImmutable $dateTimeImmutable): Date
    {
        return new self($dateTimeImmutable->format(self::DATE_TIME_FORMAT));
    }

    public static function fromDateTime(DateTime $dateTime): Date
    {
        return new self($dateTime->format(self::DATE_TIME_FORMAT));
    }

    public function asString(): string
    {
        return $this->dateTime;
    }
}