<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

//TODO Maybe move to common
final class Result
{
    /**
     * @var array<Set> & Set[]
     */
    private array $sets = [];

    private ?MaxiTieBreak $maxiTieBreak = null;

    private function __construct()
    {
    }

    public static function fromInput(Set $set, ?MaxiTieBreak $maxiTieBreak = null): self
    {
        $result = new self();

        $result->sets[] = $set;
        $result->maxiTieBreak = $maxiTieBreak;

        return $result;
    }
}