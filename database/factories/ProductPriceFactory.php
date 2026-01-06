<?php

namespace Database\Factories;

use App\Models\ProductPrice;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),      // Asocia con un producto
            'currency_id' => Currency::factory(),    // Asocia con una divisa
            'price' => $this->faker->randomFloat(2, 10, 500), // Precio
        ];
    }
}
