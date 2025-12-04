<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_products()
    {
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_create_product()
    {
        $productData = [
            'name' => 'Test Product',
            'model' => 'Model X',
            'size' => 'Large',
            'color' => 'Red',
            'quality' => 'Premium',
            'unit' => 'pcs',
            'unit_price' => 25.99,
            'selling_price' => 35.99,
            'description' => 'Test product description',
        ];

        $response = $this->actingAs($this->user)->post('/products', $productData);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function authenticated_user_can_update_product()
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product',
            'unit_price' => 29.99,
        ];

        $response = $this->actingAs($this->user)->put("/products/{$product->id}", $updatedData);

        $response->assertRedirect("/products/{$product->id}");
        $this->assertDatabaseHas('products', $updatedData);
    }

    /** @test */
    public function authenticated_user_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->delete("/products/{$product->id}");

        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}