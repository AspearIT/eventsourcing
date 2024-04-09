<?php

namespace Veldsink\EventSourcing\Resource\ProductRapportage\Repository;

use Veldsink\EventSourcing\Resource\ProductRapportage\Product;

class ProductRepository
{
    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return [
            new Product('auto', 100),
        ];
    }
}