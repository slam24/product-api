<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\CurrencyRepositoryInterface;
use App\Models\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function find(int $id)
    {
        return Currency::findOrFail($id);
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    public function update(int $id, array $data)
    {
        $currency = Currency::findOrFail($id);
        $currency->update($data);
        return $currency;
    }

    public function delete(int $id)
    {
        return Currency::destroy($id);
    }
}
