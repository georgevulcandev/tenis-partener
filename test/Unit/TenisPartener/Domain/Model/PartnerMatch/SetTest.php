<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class SetTest extends TestCase
{
    /**
     * @test
     * @dataProvider invalidInput
     */
    public function it_does_not_accept_an_invalid_input(
        int $playerOneGames,
        int $playerTwoGames,
        ?int $tieBreak
    ): void {
        $this->expectException(InvalidArgumentException::class);

        Set::add($playerOneGames, $playerTwoGames, $tieBreak);
    }

    /**
     * @test
     * @dataProvider validInput
     */
    public function it_can_be_created_from_valid_input(
        int $playerOneGames,
        int $playerTwoGames,
        ?int $tieBreak,
        string $serialized
    ): void {

        $set = Set::add($playerOneGames, $playerTwoGames, $tieBreak);

        self::assertEquals($serialized, $set->asString());
    }

    /**
     * @return array<array<int,int,int>>
     */
    public function invalidInput(): array
    {
        return [
            [6, 5, null],
            [6, 4, 1],
            [6, 6, 1],
            [6, 6, null],
            [7, 6, null],
            [7, 7, 1],
            [4, 2, null],
            [7, 5, 1],
            [10, 8, null]
        ];
    }

    /**
     * @return array<array<int,int,int>>
     */
    public function validInput()
    {
        return [
            [6, 0, null, '6-0'],
            [6, 4, null, '6-4'],
            [7, 5, null, '7-5'],
            [7, 6, 1, '7-6(1)'],
            [3, 6, null, '3-6']
        ];
    }
}