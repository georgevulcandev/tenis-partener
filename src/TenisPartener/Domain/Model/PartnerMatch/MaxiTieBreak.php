<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use Assert\Assert;
use InvalidArgumentException;

final class MaxiTieBreak
{
    private int $playerOnePoints;
    private int $playerTwoPoints;

    public function __construct(int $playerOnePoints, int $playerTwoPoints)
    {
        Assert::that($playerOnePoints)
            ->greaterOrEqualThan(0,'Player one points should be greater or equal than 0');
        Assert::that($playerTwoPoints)
            ->greaterOrEqualThan(0,'Player two points should be greater or equal than 0');

        if (abs($playerOnePoints - $playerTwoPoints) < 2) {
            throw new InvalidArgumentException('There must be a difference of at least 2 points');
        }

        if (abs($playerOnePoints - $playerTwoPoints) > 2) {
            if ($playerOnePoints !== 10 && $playerTwoPoints !== 10) {
                throw new InvalidArgumentException('One player should have 10 points');
            }
        }

        if (abs($playerOnePoints - $playerTwoPoints) === 2) {
            if ($playerOnePoints + $playerTwoPoints < 18) {
                throw new InvalidArgumentException(
                    'Maxi tie break should be played until first player reaches 10 points'
                );
            }

        }

        $this->playerOnePoints = $playerOnePoints;
        $this->playerTwoPoints = $playerTwoPoints;
    }

    public function asString(): string
    {
        return $this->playerOnePoints . '-' . $this->playerTwoPoints;
    }
}