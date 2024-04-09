<?php

namespace Veldsink\EventSourcing\Offerte\Event;

use Symfony\Component\Uid\Uuid;
use Veldsink\EventSourcing\Event;

readonly class OfferteCreated extends Event
{
    public static function event(
        Uuid $offerteUuid,
        Uuid $relatieUuid,
    ): self {
        return static::fromPayload(
            $offerteUuid,
            1,
            [
                'relatieUuid' => $relatieUuid->jsonSerialize(),
            ],
        );
    }

    public function getRelatieUuid(): Uuid
    {
        return $this->uuid('relatieUuid');
    }
}