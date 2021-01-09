<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use Assert\Assert;
use DateTimeImmutable;
use InvalidArgumentException;
use Throwable;

final class PartnerMatchDate
{
    //TODO consider extending base class Date
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
                throw new InvalidArgumentException('The provided date/time string did not match the expected format');
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

        $this->date = $dateTimeImmutable->format(self::DATE_FORMAT);
    }

    public static function fromString(string $date): self
    {
        return new self($date);
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

    public function asString(): string
    {
        return $this->date;
    }
}