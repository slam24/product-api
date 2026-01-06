<?php

namespace App\Application\UseCases\Product;

use App\Domain\Repositories\ProductRepositoryInterface;

class CreateProductUseCase
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function execute(array $data)
    {
        return $this->repository->create($data);
    }
}
