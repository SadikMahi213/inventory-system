<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_products_list()
    {
        $response = $this->actingAs($this->user)->get(route('products.index'));
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    /** @test */
    public function user_can_create_product()
    {
        $category = Category::factory()->create();
        
        $productData = [
            'product_name' => 'Test Product',
            'size' => 'Medium',
            'brand' => 'Test Brand',
            'grade' => 'A+',
            'material' => 'Plastic',
            'color' => 'Red',
            'model_no' => 'TP-001',
            'product_code' => 'PRD-TP-001',
            'unit_qty' => 10,
            'unit' => 'piece',
            'unit_rate' => 50.00,
            'total_buy' => 500.00,
            'category_id' => $category->id,
            'quantity' => 100,
            'approximate_rate' => 55.00,
            'authentication_rate' => 60.00,
            'sell_rate' => 75.00,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'product_name' => 'Test Product',
            'product_code' => 'PRD-TP-001',
        ]);
    }

    /** @test */
    public function user_can_edit_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        
        $updatedData = [
            'product_name' => 'Updated Product',
            'size' => 'Large',
            'brand' => 'Updated Brand',
            'grade' => 'A++',
            'material' => 'Metal',
            'color' => 'Blue',
            'model_no' => 'UP-001',
            'product_code' => $product->product_code, // Keep same code
            'unit_qty' => 20,
            'unit' => 'piece',
            'unit_rate' => 75.00,
            'total_buy' => 1500.00,
            'category_id' => $category->id,
            'quantity' => 200,
            'approximate_rate' => 80.00,
            'authentication_rate' => 85.00,
            'sell_rate' => 100.00,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'product_name' => 'Updated Product',
        ]);
    }

    /** @test */
    public function user_can_delete_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($this->user)
            ->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /** @test */
    public function user_can_download_excel_template()
    {
        $response = $this->actingAs($this->user)
            ->get(route('products.download.template'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}