<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\Account;

use Assert\Assert;
use DateTimeImmutable;
use InvalidArgumentException;
use Throwable;

final class CanCreateAccountDateOfBirth
{
    private DateOfBirth $dateOfBirth;
    private const ACCEPTED_AGE = 11;

    private function __construct(
        DateOfBirth $dateOfBirth,
        DateTimeImmutable $currentTime
    ) {
        if ($dateOfBirth->age($currentTime) < self::ACCEPTED_AGE) {
            throw new InvalidArgumentException('Age must be greater then 11.');
        }

        $this->dateOfBirth = $dateOfBirth;
    }

    public static function fromInputData(DateOfBirth $dateOfBirth, DateTimeImmutable $currentTime): self
    {
        return new self($dateOfBirth, $currentTime);
    }

    public function dateOfBirth(): DateOfBirth
    {
        return $this->dateOfBirth;
    }
}
