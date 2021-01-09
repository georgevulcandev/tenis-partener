<?php
declare(strict_types=1);

namespace Test\Acceptance;

use TenisPartener\Application\Email\Email;
use TenisPartener\Application\Email\Mailer;

final class MailerSpy implements Mailer
{
    /**
     * @var array<Email>
     */
    private array $sentEmails = [];

    public function send(Email $email): void
    {
        $this->sentEmails[] = $email;
    }

    /**
     * @return array<Email>
     */
    public function sentEmails(): array
    {
        return $this->sentEmails;
    }
}