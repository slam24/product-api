<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),               // Nombre del producto
            'description' => $this->faker->sentence(),     // Descripción
            'price' => $this->faker->randomFloat(2, 10, 500), // Precio
            'currency_id' => Currency::factory(),          // Crea o asigna una moneda
            'tax_cost' => $this->faker->randomFloat(2, 0, 50),
            'manufacturing_cost' => $this->faker->randomFloat(2, 5, 200),
        ];
    }
}
