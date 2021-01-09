<?php
declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Context\Context;
use TenisPartener\Application\ApplicationInterface;
use TenisPartener\Domain\Model\Account\AccountRepository;

abstract class FeatureContext implements Context
{
    /**
     * @var ServiceContainerForAcceptanceTesting
     */
    private ServiceContainerForAcceptanceTesting $serviceContainer;

    public function __construct()
    {
        $this->serviceContainer = new ServiceContainerForAcceptanceTesting();
        $this->serviceContainer->setCurrentTime('2020-10-30 10:11');
        $this->serviceContainer->setCurrentDate('2020-10-30');
    }

    protected function application(): ApplicationInterface
    {
        return $this->serviceContainer->application();
    }

    protected function serviceContainer(): ServiceContainerForAcceptanceTesting
    {
        return $this->serviceContainer;
    }

    protected function accountRepository(): AccountRepository
    {
        return $this->serviceContainer->accountRepository();
    }

    /**
     * @return array<object>
     */
    protected function dispatchedEvents(): array
    {
        return $this->serviceContainer->eventDispatcherSpy()->dispatchedEvents();
    }

    protected function clearEvents(): void
    {
        $this->serviceContainer->eventDispatcherSpy()->clearEvents();
    }
}
