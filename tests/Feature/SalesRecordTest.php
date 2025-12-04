<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesRecordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_sales_records()
    {
        $response = $this->actingAs($this->user)->get('/sales-records');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_create_sales_record()
    {
        $product = Product::factory()->create();
        $customer = Customer::factory()->create();

        $salesData = [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'price' => 35.99,
            'quantity' => 5,
            'payment_status' => 'paid',
        ];

        $response = $this->actingAs($this->user)->post('/sales-records', $salesData);

        $response->assertRedirect('/sales-records');
        $this->assertDatabaseHas('sales_records', $salesData);
    }

    /** @test */
    public function authenticated_user_can_update_sales_record()
    {
        $salesRecord = SalesRecord::factory()->create();
        $updatedData = [
            'quantity' => 10,
            'payment_status' => 'pending',
        ];

        $response = $this->actingAs($this->user)->put("/sales-records/{$salesRecord->id}", $updatedData);

        $response->assertRedirect("/sales-records/{$salesRecord->id}");
        $this->assertDatabaseHas('sales_records', $updatedData);
    }

    /** @test */
    public function authenticated_user_can_delete_sales_record()
    {
        $salesRecord = SalesRecord::factory()->create();

        $response = $this->actingAs($this->user)->delete("/sales-records/{$salesRecord->id}");

        $response->assertRedirect('/sales-records');
        $this->assertDatabaseMissing('sales_records', ['id' => $salesRecord->id]);
    }
}