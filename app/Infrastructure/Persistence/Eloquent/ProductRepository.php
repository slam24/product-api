<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ProductRepositoryInterface;
use App\Models\Product as ProductModel;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return ProductModel::with('currency')->get();
    }

    public function find(int $id)
    {
        return ProductModel::with(['currency', 'prices.currency'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return ProductModel::create($data);
    }

    public function update(int $id, array $data)
    {
        $product = ProductModel::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return ProductModel::destroy($id);
    }
}
