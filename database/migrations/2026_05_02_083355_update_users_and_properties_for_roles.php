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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['superadmin', 'admin', 'customer'])->default('customer')->after('password');
            }
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
        });

        // Migrate is_super_admin to role
        DB::table('users')->where('is_super_admin', true)->update(['role' => 'superadmin']);

        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'admin_id')) {
                $table->dropForeign(['admin_id']);
                $table->dropColumn('admin_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone', 'role']);
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
