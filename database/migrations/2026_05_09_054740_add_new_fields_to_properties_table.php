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
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'capacity')) {
                $table->integer('capacity')->nullable()->after('price');
            }
            if (!Schema::hasColumn('properties', 'status')) {
                $table->boolean('status')->default(true)->after('capacity');
            }
            if (!Schema::hasColumn('properties', 'type')) {
                $table->string('type')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'status', 'type']);
        });
    }
};
