<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_stock()
    {
        $response = $this->actingAs($this->user)->get('/stocks');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_view_stock_details()
    {
        $product = Product::factory()->create();
        $stock = Stock::factory()->create(['product_id' => $product->id]);

        $response = $this->actingAs($this->user)->get("/stocks/{$stock->id}");

        $response->assertStatus(200);
    }
}