<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Model\PartnerMatch;

use RuntimeException;

final class CannotAddPartnerMatch extends RuntimeException
{
    public static function afterANumberOfDaysPassedSincePlayed($days): self
    {
        return new self(
            sprintf(
                'Cannot add a partner match after %d days since it was played',
                $days
            )
        );
    }
}