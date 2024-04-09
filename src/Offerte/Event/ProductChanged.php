<?php

namespace Veldsink\EventSourcing\Offerte\Event;

use Symfony\Component\Uid\Uuid;
use Veldsink\EventSourcing\Event;
use Veldsink\EventSourcing\Offerte\Model\Offerte;

readonly class ProductChanged extends Event
{
    public static function event(Offerte $offerte, Uuid $productUuid, int $maandBedrag): self
    {
        return static::fromPayload(
            $offerte->domainUuid,
            $offerte->versionUp(),
            [
                'product' => $productUuid,
                'maandBedrag' => $maandBedrag,
            ],
        );
    }

    public function getProductUuid(): Uuid
    {
        return $this->uuid('product');
    }

    public function getMaandBedrag(): int
    {
        return $this->payload['maandBedrag'];
    }
}