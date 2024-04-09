<?php

namespace Veldsink\EventSourcing\Offerte\Event;

use Veldsink\EventSourcing\Event;
use Veldsink\EventSourcing\Offerte\Model\Offerte;
use Veldsink\EventSourcing\Offerte\Model\Product;
use Veldsink\EventSourcing\Offerte\Model\ProductType;

readonly class ProductAdded extends Event
{
    public static function event(Offerte $offerte, Product $product): self
    {
        return static::fromPayload(
            $offerte->domainUuid,
            $offerte->versionUp(),
            [
                'product' => $product->productUuid,
                'productType' => $product->productType->value,
                'maandBedrag' => $product->getMaandBedrag(),
            ],
        );
    }

    public function getProduct(): Product
    {
        return new Product(
            $this->uuid('product'),
            ProductType::from($this->payload['productType']),
            $this->payload['maandBedrag'],
        );
    }
}