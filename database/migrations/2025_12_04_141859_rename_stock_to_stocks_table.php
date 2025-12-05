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
        // Only rename if the source table exists and target doesn't
        if (Schema::hasTable('stock') && !Schema::hasTable('stocks')) {
            Schema::rename('stock', 'stocks');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only rename if the source table exists and target doesn't
        if (Schema::hasTable('stocks') && !Schema::hasTable('stock')) {
            Schema::rename('stocks', 'stock');
        }
    }
};
