<?php

namespace Veldsink\EventSourcing\Offerte\Repository;

use Symfony\Component\Uid\Uuid;
use Veldsink\EventSourcing\EventReplay;
use Veldsink\EventSourcing\EventStorage;
use Veldsink\EventSourcing\Offerte\Event\OfferteCreated;
use Veldsink\EventSourcing\Offerte\Model\Offerte;
use Veldsink\EventSourcing\Offerte\Model\Relatie;

class EventSourcedOfferteRepository
{
    public function __construct(
        private readonly EventStorage $eventStore,
    ) {}

    public function getOfferte(Uuid $offerteUuid): Offerte
    {
        $state = [];

        $replay = new EventReplay($this->eventStore->getEvents($offerteUuid));
        $replay->on(
            OfferteCreated::class,
            function (OfferteCreated $event) use (&$state) {
                $state['relatie_uuid'] = $event->getRelatieUuid();
            },
        );
        $replay->replay();

        return new Offerte(
            $offerteUuid,
            $replay->getVersion(),
            new Relatie($state['relatie_uuid']),
            [],
        );
    }

    public function save(Offerte $offerte): void
    {
        foreach ($offerte->popNewEvents() as $event) {
            $this->eventStore->saveEvent($event);
        }
    }
}