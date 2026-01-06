<?php

namespace App\Domain\Repositories;

interface ProductPriceRepositoryInterface
{
    public function all(int $productId);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}