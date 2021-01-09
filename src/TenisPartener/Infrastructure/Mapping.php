<?php
declare(strict_types=1);

namespace TenisPartener\Infrastructure;

use Assert\Assert;
use DateTimeImmutable;

trait Mapping
{
    protected static string $dateTimeFormat = 'Y-m-d H:i:s';

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return string
     */
    private static function asString(array $data, string $key): string
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return '';
        }

        return (string)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return string|null
     */
    private static function asStringOrNull(array $data, string $key): ?string
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return null;
        }

        return (string)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return int
     */
    private static function asInt(array $data, string $key): int
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return 0;
        }

        return (int)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return int|null
     */
    private static function asIntOrNull(array $data, string $key): ?int
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return null;
        }

        return (int)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return bool
     */
    private static function asBool(array $data, string $key): bool
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return false;
        }

        return (bool)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return bool|null
     */
    private static function asBoolOrNull(array $data, string $key): ?bool
    {
        if (!isset($data[$key]) || $data[$key] === '') {
            return null;
        }

        return (bool)$data[$key];
    }

    /**
     * @param array<string,mixed|null> $data
     * @param string $key
     * @return DateTimeImmutable
     * @throws \Exception
     */
    private static function dateTimeAsDateTimeImmutable(array $data, string $key): DateTimeImmutable
    {
        if (!isset($data[$key])) {
            return new DateTimeImmutable('now');
        }

        $dateTime = $data[$key];
        return self::dateTimeImmutableFromDateTimeString($dateTime);
    }

    private static function dateTimeImmutableFromDateTimeString(string $dateTime): DateTimeImmutable
    {
        /*
         * See http://php.net/manual/en/datetime.createfromformat.php
         */
        $formatWithUndeclaredFieldsAs0 = '!' . self::$dateTimeFormat;
        $dateTimeImmutable = DateTimeImmutable::createFromFormat($formatWithUndeclaredFieldsAs0, $dateTime);
        Assert::that($dateTimeImmutable)->isInstanceOf(DateTimeImmutable::class);

        return $dateTimeImmutable;
    }

    private static function dateTimeImmutableAsDateTimeString(DateTimeImmutable $dateTimeImmutable): string
    {
        return $dateTimeImmutable->format(self::$dateTimeFormat);
    }

    private static function removeMicrosecondsPart(DateTimeImmutable $dateTimeImmutable): DateTimeImmutable
    {
        return self::dateTimeImmutableFromDateTimeString(
            self::dateTimeImmutableAsDateTimeString($dateTimeImmutable)
        );
    }
}

