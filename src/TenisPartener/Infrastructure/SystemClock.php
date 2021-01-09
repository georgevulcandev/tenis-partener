<?php
declare(strict_types=1);

namespace TenisPartener\Infrastructure;

use DateTimeImmutable;
use TenisPartener\Application\Clock;

final class SystemClock implements Clock
{
    public function currentTime(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}