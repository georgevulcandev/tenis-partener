<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class DateOfBirthTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidDates
     */
    public function it_does_not_accept_an_invalid_date(string $invalidDate): void
    {
        $this->expectException(InvalidArgumentException::class);

        $date = DateOfBirth::fromString($invalidDate);
        echo $date->asString();
    }

    /**
     * @test
     */
    public function it_can_be_created_from_a_string(): void
    {
        $date = DateOfBirth::fromString('1982-10-01');
        self::assertEquals('1982-10-01', $date->asString());
    }

    /**
     * @test
     */
    public function it_can_be_converted_back_to_a_string(): void
    {
        self::assertEquals(
            '2020-02-01',
            DateOfBirth::fromString('2020-02-01')->asString()
        );
    }

//    /**
//     * @test
//     */
//    public function the_minimum_age_must_be_11(): void
//    {
//        $currentTime = DateTimeImmutable::createFromFormat(
//            'Y-m-d',
//            '2020-10-30'
//        );
//
//        self::assertTrue(
//            DateOfBirth::fromString('2009-10-30')->isAppropriateAge($currentTime)
//        );
//
//        self::assertFalse(
//            DateOfBirth::fromString('2009-11-30')->isAppropriateAge($currentTime)
//        );
//    }

    /**
     * @return array<string,array<int,string>>
     */
    public function invalidDates(): array
    {
        return [
            'date format does not match expected format' => ['2020-2 10:00']
        ];
    }
}