<?php
declare(strict_types=1);

namespace TenisPartener\Infrastructure;

use Assert\Assert;
use TenisPartener\Application\Application;
use TenisPartener\Application\ApplicationInterface;
use TenisPartener\Application\Clock;
use TenisPartener\Application\Email\Mailer;
use TenisPartener\Application\Email\SendEmail;
use TenisPartener\Application\EventDispatcher;
use TenisPartener\Application\EventDispatcherWithSubscribers;
use TenisPartener\Domain\Model\Account\AccountRepository;
use TenisPartener\Domain\Model\Account\AccountWasCreated;
use TenisPartener\Domain\Service\PasswordHashing;
use Test\Acceptance\FakeClock;

abstract class ServiceContainer
{
    protected ?EventDispatcher $eventDispatcher = null;

    protected ?AccountRepository $accountRepository = null;
    private ?Clock $clock = null;
    private ?PasswordHashing $passwordHashing = null;
    protected ?ApplicationInterface $application = null;

    abstract protected function accountRepository(): AccountRepository;
    abstract protected function mailer(): Mailer;

    public function setCurrentDate(string $date): void
    {
        $clock = $this->clock();
        Assert::that($clock)->isInstanceOf(FakeClock::class);
        /** @var $clock FakeClock */

        $clock->setCurrentDate($date);
    }

    public function setCurrentTime(string $dateTime): void
    {
        $clock = $this->clock();
        Assert::that($clock)->isInstanceOf(FakeClock::class);
        /** @var $clock FakeClock */

        $clock->setCurrentTime($dateTime);
    }

    protected function clock(): Clock
    {
        if ($this->clock === null) {
            $this->clock = new FakeClock();
        }

        return $this->clock;
    }

    public function application(): ApplicationInterface
    {
        if ($this->application === null) {
            $this->application = new Application(
                $this->accountRepository(),
                $this->passwordHashing(),
                $this->clock(),
                $this->eventDispatcher()
            );
        }

        return $this->application;
    }

    protected function passwordHashing(): PasswordHashing
    {
        return new BcryptPasswordHashing();
    }

    public function eventDispatcher(): EventDispatcher
    {
        if ($this->eventDispatcher === null) {
            $this->eventDispatcher = new EventDispatcherWithSubscribers();

            $this->registerEventSubscribers($this->eventDispatcher);
        }

        Assert::that($this->eventDispatcher)->isInstanceOf(EventDispatcher::class);

        return $this->eventDispatcher;
    }

    protected function registerEventSubscribers(EventDispatcherWithSubscribers $eventDispatcher): void
    {
        $eventDispatcher->subscribeToSpecificEvent(
            AccountWasCreated::class,
            [$this->sendEmail(), 'whenAccountWasCreated']
        );
    }

    private function sendEmail(): SendEmail
    {
        return new SendEmail($this->mailer());
    }
}