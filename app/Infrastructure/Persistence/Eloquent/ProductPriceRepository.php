<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\ProductPriceRepositoryInterface;
use App\Models\ProductPrice;

class ProductPriceRepository implements ProductPriceRepositoryInterface
{
    public function all(int $productId)
    {
        return ProductPrice::with('currency')
            ->where('product_id', $productId)
            ->get();
    }

    public function find(int $id)
    {
        return ProductPrice::with(['product', 'currency'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return ProductPrice::create($data);
    }

    public function update(int $id, array $data)
    {
        $price = ProductPrice::findOrFail($id);
        $price->update($data);
        return $price;
    }

    public function delete(int $id)
    {
        return ProductPrice::destroy($id);
    }
}