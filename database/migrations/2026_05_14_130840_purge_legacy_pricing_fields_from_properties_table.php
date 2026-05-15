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
            $table->dropColumn(['price', 'weekend_tier2_price', 'base_guests', 'extra_guest_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('weekend_tier2_price', 10, 2)->nullable();
            $table->integer('base_guests')->nullable();
            $table->decimal('extra_guest_price', 10, 2)->nullable();
        });
    }
};
