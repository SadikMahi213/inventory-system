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
            $table->enum('payment_status', ['paid', 'due', 'partial'])->default('due')->change();
        });
        
        // Update existing records with 'pending' status to 'due'
        DB::table('purchase_records')->where('payment_status', 'pending')->update(['payment_status' => 'due']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_records', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->change();
        });
        
        // Update existing records with 'due' status back to 'pending'
        DB::table('purchase_records')->where('payment_status', 'due')->update(['payment_status' => 'pending']);
    }
};
