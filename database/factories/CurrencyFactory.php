<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition()
    {
        return [
            'name' => $this->faker->currencyCode, // Ej: USD
            'symbol' => $this->faker->randomElement(['$', '€', '£']),
            'exchange_rate' => $this->faker->randomFloat(2, 0.1, 100),
        ];
    }
}
