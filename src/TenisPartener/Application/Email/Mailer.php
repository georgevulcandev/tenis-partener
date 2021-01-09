<?php
declare(strict_types=1);

namespace TenisPartener\Application\Email;

interface Mailer
{
    public function send(Email $mail): void;
}