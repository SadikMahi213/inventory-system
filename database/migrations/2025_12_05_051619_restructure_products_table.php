<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->after('size');
            }
            
            if (!Schema::hasColumn('products', 'grade')) {
                $table->string('grade')->nullable()->after('brand');
            }
            
            if (!Schema::hasColumn('products', 'material')) {
                $table->string('material')->nullable()->after('grade');
            }
            
            if (!Schema::hasColumn('products', 'model_no')) {
                $table->string('model_no')->nullable()->after('color');
            }
            
            if (!Schema::hasColumn('products', 'unit_qty')) {
                $table->decimal('unit_qty', 10, 2)->default(0)->after('product_code');
            }
            
            if (!Schema::hasColumn('products', 'unit_rate')) {
                $table->decimal('unit_rate', 10, 2)->default(0)->after('unit_qty');
            }
            
            if (!Schema::hasColumn('products', 'total_buy')) {
                $table->decimal('total_buy', 10, 2)->default(0)->after('unit_rate');
            }
            
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade')->after('total_buy');
            }
            
            if (!Schema::hasColumn('products', 'quantity')) {
                $table->decimal('quantity', 10, 2)->default(0)->after('category_id'); // stock
            }
            
            if (!Schema::hasColumn('products', 'approximate_rate')) {
                $table->decimal('approximate_rate', 10, 2)->default(0)->after('quantity');
            }
            
            if (!Schema::hasColumn('products', 'authentication_rate')) {
                $table->decimal('authentication_rate', 10, 2)->default(0)->after('approximate_rate');
            }
            
            if (!Schema::hasColumn('products', 'sell_rate')) {
                $table->decimal('sell_rate', 10, 2)->default(0)->after('authentication_rate');
            }
        });
        
        // Copy data from old columns to new columns (if needed)
        // Since we don't have the old columns anymore, we'll just ensure defaults are set
        
        // Make sure product_name is not nullable (it should already be)
        // This might cause issues, so we'll skip it for now
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop new columns if they exist
            $columnsToDrop = [
                'brand',
                'grade',
                'material',
                'model_no',
                'unit_qty',
                'unit_rate',
                'total_buy',
                'category_id',
                'quantity',
                'approximate_rate',
                'authentication_rate',
                'sell_rate'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('products', $column)) {
                    if ($column === 'category_id') {
                        $table->dropForeign(['category_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};