<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('total_price');
            $table->string('tracking_number')->nullable()->after('status');
            $table->string('courier')->nullable()->after('tracking_number');
            $table->timestamp('shipped_at')->nullable()->after('courier');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->text('delivery_notes')->nullable()->after('delivered_at');
        });
    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status','tracking_number','courier','shipped_at','delivered_at','delivery_notes']);
        });
    }
};
