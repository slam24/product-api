<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Currency;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $headers;

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
    }

    public function test_list_currencies()
    {
        Currency::factory()->count(3)->create();
        $response = $this->getJson('/api/v1/currencies', $this->headers);
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_create_currency()
    {
        $data = ['name' => 'Dólar', 'symbol' => '$', 'exchange_rate' => 1.0];
        $response = $this->postJson('/api/v1/currencies', $data, $this->headers);
        $response->assertStatus(201)->assertJsonFragment(['name' => 'Dólar']);
        $this->assertDatabaseHas('currencies', ['name' => 'Dólar']);
    }

    public function test_update_currency()
    {
        $currency = Currency::factory()->create();
        $response = $this->putJson("/api/v1/currencies/{$currency->id}", ['name' => 'Euro'], $this->headers);
        $response->assertStatus(200)->assertJsonFragment(['name' => 'Euro']);
        $this->assertDatabaseHas('currencies', ['name' => 'Euro']);
    }

    public function test_delete_currency()
    {
        $currency = Currency::factory()->create();
        $response = $this->deleteJson("/api/v1/currencies/{$currency->id}", [], $this->headers);
        $response->assertStatus(200)->assertJson(['message' => 'Deleted']);
        $this->assertDatabaseMissing('currencies', ['id' => $currency->id]);
    }
}
