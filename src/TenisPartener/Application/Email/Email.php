<?php
declare(strict_types=1);

namespace TenisPartener\Application\Email;

interface Email
{
    public function recipient(): string;

    public function subject(): string;

    public function template(): string;
}