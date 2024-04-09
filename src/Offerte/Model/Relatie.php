<?php

namespace Veldsink\EventSourcing\Offerte\Model;

use Symfony\Component\Uid\Uuid;

class Relatie
{
    public function __construct(
        private readonly Uuid $relatieUuid,
    ) {}
}