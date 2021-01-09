<?php
declare(strict_types=1);

namespace Test\Acceptance;

use TenisPartener\Application\EventDispatcher;
use TenisPartener\Application\EventDispatcherWithSubscribers;
use TenisPartener\Domain\Model\Account\AccountRepository;
use TenisPartener\Domain\Service\PasswordHashing;
use TenisPartener\Infrastructure\ServiceContainer;

final class ServiceContainerForAcceptanceTesting extends ServiceContainer
{
    private ?EventDispatcherSpy $eventDispatcherSpy = null;

    private ?MailerSpy $mailer = null;

    public function accountRepository(): AccountRepository
    {
        if ($this->accountRepository === null) {
            $this->accountRepository = new InMemoryAccountRepository;
        }

        return $this->accountRepository;
    }

    public function passwordHashing(): PasswordHashing
    {
        return parent::passwordHashing();
    }

    public function eventDispatcherSpy(): EventDispatcherSpy
    {
        if ($this->eventDispatcherSpy === null) {
            $this->eventDispatcherSpy = new EventDispatcherSpy();
        }

        return $this->eventDispatcherSpy;
    }

    protected function registerEventSubscribers(EventDispatcherWithSubscribers $eventDispatcher): void
    {
        parent::registerEventSubscribers($eventDispatcher);

        $eventDispatcher->subscribeToAllEvents([$this->eventDispatcherSpy(), 'notify']);
    }

    public function mailer(): MailerSpy
    {
        if ($this->mailer === null) {
            $this->mailer = new MailerSpy();
        }

        return $this->mailer;
    }
}

