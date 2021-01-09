<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use Assert\Assert;
use DateTimeImmutable;
use TenisPartener\Domain\Model\Account\AccountId;

final class PartnerMatch
{
    private const MAX_DAYS_SINCE_PLAYED = 7;

    private array $events = [];

    //bestOfTree
    //2SetsWithMaxiTieBreak

    private PartnerMatchId $id;
    private string $city;
    private string $tennisClub;
    private PartnerMatchDate $playedAt;
    private AccountId $addedBy;
    private AccountId $opponent;
    private bool $won;
    private bool $forfeit;
    private Result $result;
    private DateTimeImmutable $addedAt;

    private function __construct()
    {
    }

    public static function add(
        PartnerMatchId $friendlyGameId,
        string $city,
        string $tennisClub,
        PartnerMatchDate $playedAt,
        AccountId $addedBy,
        AccountId $opponent,
        bool $won,
        bool $forfeit,
        Result $result,
        DateTimeImmutable $addedAt
    ): self {
        $friendlyGame = new self();

        if (self::howManyDaysSincePlayed($playedAt, $addedAt) > self::MAX_DAYS_SINCE_PLAYED) {
            throw CannotAddPartnerMatch::afterANumberOfDaysPassedSincePlayed(self::MAX_DAYS_SINCE_PLAYED);
        }

        Assert::that($city)->notEmpty('City must not be empty');
        Assert::that($tennisClub)->notEmpty('Tennis club must not be empty');

        $friendlyGame->id = $friendlyGameId;
        $friendlyGame->city = $city;
        $friendlyGame->tennisClub = $tennisClub;
        $friendlyGame->playedAt = $playedAt;
        $friendlyGame->addedBy = $addedBy;
        $friendlyGame->opponent = $opponent;
        $friendlyGame->won = $won;
        $friendlyGame->forfeit = $forfeit;
        $friendlyGame->addedAt = $addedAt;
        $friendlyGame->result = $result;

        $friendlyGame->events[] = new PartnerMatchWasAdded($friendlyGame);

        return $friendlyGame;
    }

    private static function howManyDaysSincePlayed(PartnerMatchDate $playedAt, DateTimeImmutable $addedAt): int
    {
        return $playedAt->asPhpDateTime()->diff($addedAt)->d;
    }

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}