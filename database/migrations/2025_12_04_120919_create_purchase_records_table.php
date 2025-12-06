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
    Schema::create('purchase_records', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->unsignedBigInteger('product_id');
        $table->string('product_name')->nullable();   // ✔ remove ->change()
        $table->string('model')->nullable();
        $table->string('size')->nullable();
        $table->string('color')->nullable();
        $table->string('quality')->nullable();
        $table->integer('quantity');
        $table->string('unit');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('total_price', 12, 2);
        $table->unsignedBigInteger('supplier_id');
        $table->timestamps();
         $table->enum('payment_status', ['pending','paid','partial'])->default('pending'); 
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_records');
    }
};
