<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\ProfitLoss;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfitLossTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_profit_loss_records()
    {
        $response = $this->actingAs($this->user)->get('/profit-loss');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_view_profit_loss_details()
    {
        $product = Product::factory()->create();
        $profitLoss = ProfitLoss::factory()->create(['product_id' => $product->id]);

        $response = $this->actingAs($this->user)->get("/profit-loss/{$profitLoss->id}");

        $response->assertStatus(200);
    }
}