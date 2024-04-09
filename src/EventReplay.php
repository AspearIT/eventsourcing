<?php

namespace Veldsink\EventSourcing;

class EventReplay
{
    private array $listeners;

    /**
     * @param Event[] $events
     */
    public function __construct(
        private readonly array $events,
    ) {
        if (empty($events)) {
            throw new \InvalidArgumentException('No events to replay');
        }
    }

    public function on(string $event, callable $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function replay(): void
    {
        foreach ($this->events as $event) {
            foreach ($this->listeners[get_class($event)] ?? [] as $listener) {
                $listener($event);
            }
        }
    }

    public function getVersion(): int
    {
        return $this->events[array_key_last($this->events)]->version;
    }
}