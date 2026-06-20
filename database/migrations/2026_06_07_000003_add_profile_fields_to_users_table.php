<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone'))   $table->string('phone')->nullable()->after('role');
            if (!Schema::hasColumn('users', 'address')) $table->text('address')->nullable()->after('phone');
            if (!Schema::hasColumn('users', 'avatar'))  $table->string('avatar')->nullable()->after('address');
            if (!Schema::hasColumn('users', 'city'))    $table->string('city')->nullable()->after('avatar');
            if (!Schema::hasColumn('users', 'dob'))     $table->date('dob')->nullable()->after('city');
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone','address','avatar','city','dob']);
        });
    }
};
