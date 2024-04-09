<?php

namespace Veldsink\EventSourcing\Offerte\Event;

use Symfony\Component\Uid\Uuid;
use Veldsink\EventSourcing\Event;
use Veldsink\EventSourcing\Offerte\Model\Offerte;

readonly class ProductRemoved extends Event
{
    public static function event(Offerte $offerte, Uuid $productUuid): self
    {
        return static::fromPayload(
            $offerte->domainUuid,
            $offerte->versionUp(),
            [
                'productUuid' => $productUuid->jsonSerialize(),
            ],
        );
    }

    public function getProductUuid(): Uuid
    {
        return Uuid::fromString($this->payload['productUuid']);
    }
}