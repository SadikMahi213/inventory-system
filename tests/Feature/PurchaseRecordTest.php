<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseRecordTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_view_purchase_records()
    {
        $response = $this->actingAs($this->user)->get('/purchase-records');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_create_purchase_record()
    {
        $product = Product::factory()->create();
        $supplier = Supplier::factory()->create();

        $purchaseData = [
            'date' => '2023-01-01',
            'product_id' => $product->id,
            'quantity' => 100,
            'unit_price' => 25.99,
            'supplier_id' => $supplier->id,
            'payment_status' => 'paid',
        ];

        $response = $this->actingAs($this->user)->post('/purchase-records', $purchaseData);

        $response->assertRedirect('/purchase-records');
        $this->assertDatabaseHas('purchase_records', $purchaseData);
    }

    /** @test */
    public function authenticated_user_can_update_purchase_record()
    {
        $purchaseRecord = PurchaseRecord::factory()->create();
        $updatedData = [
            'quantity' => 150,
            'payment_status' => 'pending',
        ];

        $response = $this->actingAs($this->user)->put("/purchase-records/{$purchaseRecord->id}", $updatedData);

        $response->assertRedirect("/purchase-records/{$purchaseRecord->id}");
        $this->assertDatabaseHas('purchase_records', $updatedData);
    }

    /** @test */
    public function authenticated_user_can_delete_purchase_record()
    {
        $purchaseRecord = PurchaseRecord::factory()->create();

        $response = $this->actingAs($this->user)->delete("/purchase-records/{$purchaseRecord->id}");

        $response->assertRedirect('/purchase-records');
        $this->assertDatabaseMissing('purchase_records', ['id' => $purchaseRecord->id]);
    }
}