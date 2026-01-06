<?php

namespace App\Domain\Entities;

class Product
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public int $currencyId,
        public float $taxCost,
        public float $manufacturingCost
    ) {}
}

