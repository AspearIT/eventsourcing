<?php

namespace Veldsink\EventSourcing\Offerte\Model;

use Symfony\Component\Uid\Uuid;
use Veldsink\EventSourcing\Domain;
use Veldsink\EventSourcing\Offerte\Event\OfferteCreated;
use Veldsink\EventSourcing\Offerte\Event\ProductAdded;
use Veldsink\EventSourcing\Offerte\Event\ProductChanged;
use Veldsink\EventSourcing\Offerte\Event\ProductRemoved;

class Offerte extends Domain
{
    public function __construct(
        Uuid $offerteUuid,
        int $version,
        private readonly Relatie $relatie,
        private array $producten,
    ) {
        parent::__construct($offerteUuid, $version);
    }

    public static function create(Uuid $relatieUuid): self
    {
        $self = new self(
            Uuid::v4(),
            0,
            new Relatie($relatieUuid),
            [],
        );
        $self->event(OfferteCreated::event($self->domainUuid, $relatieUuid));
        return $self;
    }

    public function addProduct(ProductType $productType, int $maandBedrag): Uuid
    {
        $this->producten[] = $product = new Product(
            $productUuid = Uuid::v4(),
            $productType,
            $maandBedrag,
        );
        $this->event(ProductAdded::event($this, $product));
        return $productUuid;
    }

    public function removeProduct(Uuid $productUuid): void
    {
        //Make sure the product exists
        $this->getProduct($productUuid);

        //Remove the product
        $this->producten = array_filter(
            $this->producten,
            fn (Product $p) => $p->productUuid->jsonSerialize() !== $productUuid->jsonSerialize(),
        );
        $this->event(ProductRemoved::event($this, $productUuid));
    }

    public function changeProduct(Uuid $productUuid, int $maandBedrag): void
    {
        $product = $this->getProduct($productUuid);
        if ($product->getMaandBedrag() === $maandBedrag) {
            return;
        }
        $product->setMaandBedrag($maandBedrag);
        $this->event(ProductChanged::event($this, $product->productUuid, $maandBedrag));
    }

    private function getProduct(Uuid $uuid): Product
    {
        foreach ($this->producten as $product) {
            if ($product->productUuid->jsonSerialize() === $uuid->jsonSerialize()) {
                return $product;
            }
        }
        throw new \RuntimeException('Product not found');
    }

    /**
     * @return Product[]
     */
    public function getProducten(): array
    {
        return $this->producten;
    }

    public function getRelatie(): Relatie
    {
        return $this->relatie;
    }
}