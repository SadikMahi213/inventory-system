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
        Schema::table('products', function (Blueprint $table) {
            // Check each column before making it nullable to avoid errors
            if (Schema::hasColumn('products', 'product_code')) {
                $table->string('product_code', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'product_name')) {
                $table->string('product_name', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'model')) {
                $table->string('model', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'size')) {
                $table->string('size', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'brand')) {
                $table->string('brand', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'grade')) {
                $table->string('grade', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'material')) {
                $table->string('material', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'color')) {
                $table->string('color', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'model_no')) {
                $table->string('model_no', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'quality')) {
                $table->string('quality', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'unit')) {
                $table->string('unit', 255)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'unit_qty')) {
                $table->decimal('unit_qty', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'unit_rate')) {
                $table->decimal('unit_rate', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'total_buy')) {
                $table->decimal('total_buy', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'quantity')) {
                $table->decimal('quantity', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'approximate_rate')) {
                $table->decimal('approximate_rate', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'authentication_rate')) {
                $table->decimal('authentication_rate', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'sell_rate')) {
                $table->decimal('sell_rate', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'selling_price')) {
                $table->decimal('selling_price', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->nullable()->change();
            }
            
            if (Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Note: We cannot easily restore the original constraints without knowing the exact previous state
            // This is a simplified rollback that makes some key fields non-nullable again
            if (Schema::hasColumn('products', 'product_code')) {
                $table->string('product_code', 255)->nullable(false)->change();
            }
            
            if (Schema::hasColumn('products', 'product_name')) {
                $table->string('product_name', 255)->nullable(false)->change();
            }
            
            if (Schema::hasColumn('products', 'unit')) {
                $table->string('unit', 255)->nullable(false)->change();
            }
        });
    }
};