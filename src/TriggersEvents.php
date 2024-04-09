<?php

namespace Veldsink\EventSourcing;

trait TriggersEvents
{
    private array $events;

    public function event(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return Event[]
     */
    public function popNewEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}