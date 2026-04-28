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
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'room_type')) {
                $table->dropColumn('room_type');
            }
            if (!Schema::hasColumn('bookings', 'property_id')) {
                $table->foreignId('property_id')->nullable()->constrained('properties')->nullOnDelete();
            }
            $table->string('event_type')->nullable();
            $table->string('package_name')->nullable();
            $table->json('amenities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('room_type')->nullable();
            if (Schema::hasColumn('bookings', 'property_id')) {
                $table->dropForeign(['property_id']);
                $table->dropColumn('property_id');
            }
            $table->dropColumn(['event_type', 'package_name', 'amenities']);
        });
    }
};
