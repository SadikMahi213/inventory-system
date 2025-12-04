<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CsvTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function authenticated_user_can_access_csv_import_export_page()
    {
        $response = $this->actingAs($this->user)->get('/csv');

        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_export_products_csv()
    {
        $response = $this->actingAs($this->user)->get('/csv/export/products');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function authenticated_user_can_export_purchase_records_csv()
    {
        $response = $this->actingAs($this->user)->get('/csv/export/purchase-records');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function authenticated_user_can_export_sales_records_csv()
    {
        $response = $this->actingAs($this->user)->get('/csv/export/sales-records');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function authenticated_user_can_export_stock_csv()
    {
        $response = $this->actingAs($this->user)->get('/csv/export/stock');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /** @test */
    public function authenticated_user_can_export_profit_loss_csv()
    {
        $response = $this->actingAs($this->user)->get('/csv/export/profit-loss');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}