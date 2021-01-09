<?php
declare(strict_types=1);

namespace Test\Acceptance;

final class EventDispatcherSpy
{
    /**
     * @var array<object>
     */
    private array $dispatchedEvents = [];

    public function notify(object $event): void
    {
        //$this->printEventOnSingleLine($event);

        $this->dispatchedEvents[] = $event;
    }

    private function printEventOnSingleLine(object $event): void
    {
        //echo Event::asString($event) . "\n";
    }

    /**
     * @return array<object>
     */
    public function dispatchedEvents(): array
    {
        return $this->dispatchedEvents;
    }

    public function clearEvents(): void
    {
        $this->dispatchedEvents = [];
    }
}