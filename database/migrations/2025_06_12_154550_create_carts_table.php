<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
Schema::create('carts', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('product_id');
    $table->string('buyer_name')->nullable();
    $table->text('buyer_address')->nullable();  // <-- updated
    $table->string('buyer_contact')->nullable(); // <-- updated
    $table->integer('quantity');
    $table->decimal('total_price', 10, 2)->nullable(); // <-- updated
    $table->string('status')->default('pending');
    $table->timestamps();

    $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
});
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
