<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('type')->default('general'); // general, product, order
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('feedbacks');
    }
};
