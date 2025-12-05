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
            // Rename columns to match the expected structure
            if (Schema::hasColumn('products', 'name') && !Schema::hasColumn('products', 'product_name')) {
                $table->renameColumn('name', 'product_name');
            }
            
            if (Schema::hasColumn('products', 'model') && !Schema::hasColumn('products', 'model_no')) {
                $table->renameColumn('model', 'model_no');
            }
            
            if (Schema::hasColumn('products', 'unit_price') && !Schema::hasColumn('products', 'unit_rate')) {
                $table->renameColumn('unit_price', 'unit_rate');
            }
            
            if (Schema::hasColumn('products', 'selling_price') && !Schema::hasColumn('products', 'sell_rate')) {
                $table->renameColumn('selling_price', 'sell_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rename columns back to original names
            if (Schema::hasColumn('products', 'product_name') && !Schema::hasColumn('products', 'name')) {
                $table->renameColumn('product_name', 'name');
            }
            
            if (Schema::hasColumn('products', 'model_no') && !Schema::hasColumn('products', 'model')) {
                $table->renameColumn('model_no', 'model');
            }
            
            if (Schema::hasColumn('products', 'unit_rate') && !Schema::hasColumn('products', 'unit_price')) {
                $table->renameColumn('unit_rate', 'unit_price');
            }
            
            if (Schema::hasColumn('products', 'sell_rate') && !Schema::hasColumn('products', 'selling_price')) {
                $table->renameColumn('sell_rate', 'selling_price');
            }
        });
    }
};