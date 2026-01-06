<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\ProductPrice;

class ProductPriceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $headers;
    protected $product;
    protected $currency;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
        $token = $this->user->createToken('test')->plainTextToken;
        $this->headers = [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        $this->currency = Currency::factory()->create();
        $this->product = Product::factory()->create();
    }

    public function test_list_prices()
    {
        ProductPrice::factory()->count(3)->create(['product_id' => $this->product->id]);
        $response = $this->getJson("/api/v1/products/{$this->product->id}/prices", $this->headers);
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_create_price()
    {
        $data = ['currency_id' => $this->currency->id, 'price' => 120.0];
        $response = $this->postJson("/api/v1/products/{$this->product->id}/prices", $data, $this->headers);
        $response->assertStatus(201)->assertJsonFragment(['price' => 120.0]);
        $this->assertDatabaseHas('product_prices', ['price' => 120.0]);
    }

    public function test_delete_price()
    {
        $price = ProductPrice::factory()->create(['product_id' => $this->product->id]);
        $response = $this->deleteJson("/api/v1/products/{$this->product->id}/prices/{$price->id}", [], $this->headers);
        $response->assertStatus(200)->assertJson(['message' => 'Deleted']);
        $this->assertDatabaseMissing('product_prices', ['id' => $price->id]);
    }
}
