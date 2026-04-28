<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'property_id')) {
                $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null')->after('guests');
            }
            if (!Schema::hasColumn('bookings', 'event_type')) {
                $table->string('event_type')->nullable()->after('property_id');
            }
            if (!Schema::hasColumn('bookings', 'package_name')) {
                $table->string('package_name')->nullable()->after('event_type');
            }
            if (!Schema::hasColumn('bookings', 'notes')) {
                $table->text('notes')->nullable()->after('package_name');
            }
            if (!Schema::hasColumn('bookings', 'amenities')) {
                $table->json('amenities')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('bookings', 'amenity_total')) {
                $table->decimal('amenity_total', 10, 2)->default(0)->after('amenities');
            }
            if (!Schema::hasColumn('bookings', 'base_amount')) {
                $table->decimal('base_amount', 10, 2)->default(0)->after('amenity_total');
            }
            if (!Schema::hasColumn('bookings', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0)->after('base_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'amount') && !Schema::hasColumn('bookings', 'room_type')) {
                $table->dropColumn('amount');
            }
            if (Schema::hasColumn('bookings', 'base_amount')) {
                $table->dropColumn('base_amount');
            }
            if (Schema::hasColumn('bookings', 'amenity_total')) {
                $table->dropColumn('amenity_total');
            }
            if (Schema::hasColumn('bookings', 'amenities')) {
                $table->dropColumn('amenities');
            }
            if (Schema::hasColumn('bookings', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('bookings', 'package_name')) {
                $table->dropColumn('package_name');
            }
            if (Schema::hasColumn('bookings', 'event_type')) {
                $table->dropColumn('event_type');
            }
            if (Schema::hasColumn('bookings', 'property_id')) {
                $table->dropForeign(['property_id']);
                $table->dropColumn('property_id');
            }
        });
    }
};