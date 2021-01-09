<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use Assert\Assert;

final class PartnerMatchId
{
    private string $id;

    private function __construct(string $id)
    {
        Assert::that($id)->uuid();

        $this->id = $id;
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public function asString(): string
    {
        return $this->id;
    }
}