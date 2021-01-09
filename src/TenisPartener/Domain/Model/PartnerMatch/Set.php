<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use Assert\Assert;
use InvalidArgumentException;

final class Set
{
    private int $playerOneGames;
    private int $playerTwoGames;
    private ?int $tieBreak = null;

    private function __construct(int $playerOneGames, int $playerTwoGames, ?int $tieBreak)
    {
        Assert::that($playerOneGames)
            ->integer('Player one games must be an integer')
            ->greaterOrEqualThan(0,'Player one games must be >= 0')
            ->lessOrEqualThan(7, 'Player one games must be <= 7');

        Assert::that($playerTwoGames)
            ->integer('Player two games must be an integer')
            ->greaterOrEqualThan(0,'Player two games must be >= 0')
            ->lessOrEqualThan(7, 'Player two games must be <= 7');

        Assert::thatNullOr($tieBreak)->integer('Tie Break must be an integer');

        if (($playerOneGames === 7 && $playerTwoGames === 6) ||
            ($playerOneGames === 6 && $playerTwoGames === 7)
        ) {
            Assert::that($tieBreak)
                ->notNull('Tie Break must be specified')
                ->integer('Tie break must be an integer')
                ->greaterOrEqualThan(0, 'Tie break must be >= 0');
        } elseif (abs($playerOneGames - $playerTwoGames) < 2) {
            throw new InvalidArgumentException('There must be a difference of at least 2 games');
        } elseif (abs($playerOneGames - $playerTwoGames) >= 2) {
            Assert::that($tieBreak)->null('We can only have tie break in 7-6 situation');
        }

        if ($playerOneGames !== 7 && $playerTwoGames !== 7) {
            if ($playerOneGames !== 6 && $playerTwoGames !== 6) {
                throw new InvalidArgumentException('One player must win 6 games in order to finish a set');
            }
        }

        $this->playerOneGames = $playerOneGames;
        $this->playerTwoGames = $playerTwoGames;
        $this->tieBreak = $tieBreak;
    }

    public static function add(int $playerOneGames, int $playerTwoGames, ?int $tieBreak): self
    {
        return new self($playerOneGames, $playerTwoGames, $tieBreak);
    }

    public function playerOneGames(): int
    {
        return $this->playerOneGames;
    }

    public function playerTwoGames(): int
    {
        return $this->playerOneGames;
    }

    public function asString(): string
    {
        $tieBreakSerialized = $this->tieBreak ? '(' . $this->tieBreak . ')' : '';
        return $this->playerOneGames . '-' . $this->playerTwoGames . $tieBreakSerialized;
    }
}