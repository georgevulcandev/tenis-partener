<?php
declare(strict_types=1);

namespace TenisPartener\Application;

use DateTimeImmutable;

interface Clock
{
    public function currentTime(): DateTimeImmutable;
}