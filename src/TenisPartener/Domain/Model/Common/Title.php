<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Common;

use Assert\Assert;

final class Title
{
    private string $title;

    private function __construct(string $title)
    {
        Assert::that($title)->notEmpty();
        $this->title = $title;
    }

    public static function fromString(string $string): self
    {
        return new self($string);
    }

    public function asString(): string
    {
        return $this->title;
    }
}