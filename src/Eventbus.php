<?php

namespace Veldsink\EventSourcing;

use Veldsink\EventSourcing\Resource\ProductRapportage\Listener\ProductRapportageListener;

class Eventbus
{
    public function __construct(
        private readonly ProductRapportageListener $listener,
    ) {

    }

    public function dispatch(Event $event): void
    {
        $this->listener->handle($event);
    }
}