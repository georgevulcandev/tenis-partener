<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PartnerMatchDateTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidDates
     */
    public function it_does_not_accept_an_invalid_date(string $invalidDate): void
    {
        $this->expectException(InvalidArgumentException::class);

        PartnerMatchDate::fromString($invalidDate);
    }

    /**
     * @test
     */
    public function it_can_be_created_from_a_string(): void
    {
        $partnerMatchDate = PartnerMatchDate::fromString('2020-04-01',);

        self::assertEquals('2020-04-01', $partnerMatchDate->asString());
    }

    /**
     * @test
     */
    public function it_can_be_converted_back_to_a_string(): void
    {
        self::assertEquals('2020-02-01', PartnerMatchDate::fromString('2020-02-01')->asString());
    }

    /**
     * @return array<string,array<int,string>>
     */
    public function invalidDates(): array
    {
        return [
            'date format does not match expected format' => ['2020-2']
        ];
    }
}