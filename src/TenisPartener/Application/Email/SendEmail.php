<?php
declare(strict_types=1);

namespace TenisPartener\Application\Email;

use TenisPartener\Domain\Model\Account\AccountWasCreated;

final class SendEmail
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function whenAccountWasCreated(AccountWasCreated $event): void
    {
        $this->mailer->send(new AccountWasCreatedEmail($event->account()));
    }
}