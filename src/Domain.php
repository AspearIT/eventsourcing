<?php

namespace Veldsink\EventSourcing;

use Symfony\Component\Uid\Uuid;

abstract class Domain
{
    use TriggersEvents;

    public function __construct(
        public readonly Uuid $domainUuid,
        private int $version,
    ) {}

    public function versionUp(): int
    {
        return ++$this->version;
    }
}