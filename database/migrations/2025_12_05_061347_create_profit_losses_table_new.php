<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profit_losses', function (Blueprint $table) {
            $table->id(); // bigint, auto
            $table->date('date');
            $table->decimal('total_sales', 15, 2);
            $table->decimal('total_purchase_cost', 15, 2);
            $table->decimal('operating_cost', 15, 2)->default(0);
            $table->decimal('net_profit', 15, 2);
            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_losses');
    }
};
