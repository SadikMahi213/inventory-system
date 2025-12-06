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
        Schema::table('purchase_records', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('purchase_records', 'invoice_no')) {
                $table->string('invoice_no')->nullable()->after('date');
            }
            
            // Handle color columns - consolidate into color_or_material
            if (Schema::hasColumn('purchase_records', 'color') && !Schema::hasColumn('purchase_records', 'color_or_material')) {
                // Rename color to color_or_material
                $table->renameColumn('color', 'color_or_material');
            } elseif (Schema::hasColumn('purchase_records', 'color') && Schema::hasColumn('purchase_records', 'color_or_material')) {
                // Both columns exist - move data from color to color_or_material and drop color
                DB::statement("UPDATE purchase_records SET color_or_material = color WHERE color_or_material IS NULL AND color IS NOT NULL");
                $table->dropColumn('color');
            } elseif (!Schema::hasColumn('purchase_records', 'color_or_material')) {
                // Neither column exists - create color_or_material
                $table->string('color_or_material')->nullable()->after('size');
            }
            
            // Make columns nullable
            $table->date('date')->nullable()->change();
            $table->unsignedBigInteger('product_id')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->string('unit')->nullable()->change();
            $table->decimal('unit_price', 10, 2)->nullable()->change();
            $table->decimal('total_price', 12, 2)->nullable()->change();
            $table->unsignedBigInteger('supplier_id')->nullable()->change();
            
            // Update payment_status to be nullable (it already has the right enum values)
            DB::statement("ALTER TABLE purchase_records MODIFY COLUMN payment_status ENUM('paid', 'due', 'partial') NULL DEFAULT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_records', function (Blueprint $table) {
            // Revert changes - make columns non-nullable again
            $table->date('date')->nullable(false)->change();
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
            $table->integer('quantity')->nullable(false)->change();
            $table->string('unit')->nullable(false)->change();
            $table->decimal('unit_price', 10, 2)->nullable(false)->change();
            $table->decimal('total_price', 12, 2)->nullable(false)->change();
            $table->unsignedBigInteger('supplier_id')->nullable(false)->change();
            
            // Remove added columns if they exist
            if (Schema::hasColumn('purchase_records', 'invoice_no')) {
                $table->dropColumn('invoice_no');
            }
            
            // Revert payment_status to not nullable with default
            DB::statement("ALTER TABLE purchase_records MODIFY COLUMN payment_status ENUM('paid', 'due', 'partial') NOT NULL DEFAULT 'due'");
        });
    }
};