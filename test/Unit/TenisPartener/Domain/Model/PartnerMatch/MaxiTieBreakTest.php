<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MaxiTieBreakTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidInput
     */
    public function it_does_not_accept_an_invalid_input(int $playerOnePoints, int $playerTwoPoints): void
    {
        $this->expectException(InvalidArgumentException::class);

        $maxiTieBreak = new MaxiTieBreak($playerOnePoints, $playerTwoPoints);
    }

    /**
     * @test
     * @dataProvider validInput
     */
    public function it_can_be_created_from_valid_input(
        int $playerOnePoints,
        int $playerTwoPoints,
        string $serialized
    ): void {

        $maxiTieBreak = new MaxiTieBreak($playerOnePoints, $playerTwoPoints);
        self::assertEquals($serialized, $maxiTieBreak->asString());
    }

    /**
     * @return array<array<int,int,int>>
     */
    public function invalidInput(): array
    {
        return [
            [6, 5],
            [6, 4],
            [6, 6],
            [10, 9],
            [11, 10],
            [11, 8]
        ];
    }

    /**
     * @return array<array<int,int,int>>
     */
    public function validInput()
    {
        return [
            [10, 8, '10-8'],
            [10, 0, '10-0'],
            [11, 9, '11-9'],
            [9, 11, '9-11'],
            [0, 10, '0-10']
        ];
    }
}