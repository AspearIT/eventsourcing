<?php

namespace Veldsink\EventSourcing;

use Symfony\Component\Uid\Uuid;

abstract readonly class Event
{
    private function __construct(
        public Uuid $domainUuid,
        public int $version,
        public array $payload,
    ) {}

    public static function fromPayload(Uuid $domainUuid, int $version, array $payload): static
    {
        return new static($domainUuid, $version, $payload);
    }

    protected function uuid(string $property): Uuid
    {
        return Uuid::fromString($this->payload[$property]);
    }
}