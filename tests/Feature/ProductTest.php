<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $token = $this->user->createToken('test')->plainTextToken;
        $this->headers = [
            'Authorization' => "Bearer $token",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        Currency::factory()->create(['id' => 1, 'name' => 'USD', 'symbol' => '$', 'exchange_rate' => 1.0]);
    }

    public function test_list_products()
    {
        Product::factory()->count(3)->create();
        $response = $this->getJson('/api/v1/products', $this->headers);
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_create_product()
    {
        $data = [
            'name' => 'Producto 1',
            'description' => 'Desc',
            'price' => 100.5,
            'currency_id' => 1,
            'tax_cost' => 10.5,
            'manufacturing_cost' => 50.0
        ];

        $response = $this->postJson('/api/v1/products', $data, $this->headers);
        $response->assertStatus(201)->assertJsonFragment(['name' => 'Producto 1']);
        $this->assertDatabaseHas('products', ['name' => 'Producto 1']);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();
        $response = $this->putJson("/api/v1/products/{$product->id}", [
            'name' => 'Updated Product'
        ], $this->headers);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Product']);
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson("/api/v1/products/{$product->id}", [], $this->headers);
        $response->assertStatus(200)->assertJson(['message' => 'Deleted']);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
