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
            $table->decimal('weekday_tier2_price', 10, 2)->nullable()->after('weekday_price');
            $table->decimal('weekend_tier2_price', 10, 2)->nullable()->after('weekend_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['weekday_tier2_price', 'weekend_tier2_price']);
        });
    }
};
