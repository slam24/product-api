<?php

namespace App\Application\UseCases\ProductPrice;

use App\Domain\Repositories\ProductPriceRepositoryInterface;

class CreateProductPriceUseCase
{
    public function __construct(
        private ProductPriceRepositoryInterface $repository
    ) {}

    public function execute(array $data)
    {
        return $this->repository->create($data);
    }
}