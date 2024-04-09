<?php

namespace Veldsink\EventSourcing\Offerte\Model;

use Symfony\Component\Uid\Uuid;

class Product
{
    public function __construct(
        public readonly Uuid $productUuid,
        public readonly ProductType $productType,
        private int $maandBedrag,
    ) {
        $this->maandBedragShouldBeHigherThanZero($this->maandBedrag);
    }

    public function getMaandBedrag(): int
    {
        return $this->maandBedrag;
    }

    public function setMaandBedrag(int $maandBedrag): void
    {
        $this->maandBedragShouldBeHigherThanZero($maandBedrag);
        $this->maandBedrag = $maandBedrag;
    }

    private function maandBedragShouldBeHigherThanZero(int $maandBedrag): void
    {
        if ($maandBedrag <= 0) {
            throw new \InvalidArgumentException('Maandbedrag moet hoger zijn dan 0');
        }
    }
}