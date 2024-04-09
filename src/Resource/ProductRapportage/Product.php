<?php

namespace Veldsink\EventSourcing\Resource\ProductRapportage;

use Veldsink\EventSourcing\Offerte\Model\ProductType;

readonly class Product
{
    public function __construct(
        public string $productType,
        public int $totaalMaandBedrag,
    ) {}
}