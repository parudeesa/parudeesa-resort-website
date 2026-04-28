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
            if (!Schema::hasColumn('bookings', 'base_price')) {
                $table->decimal('base_price', 10, 2)->after('guests')->default(0);
            }
            if (!Schema::hasColumn('bookings', 'amenities_total')) {
                $table->decimal('amenities_total', 10, 2)->after('base_price')->default(0);
            }
            if (!Schema::hasColumn('bookings', 'grand_total')) {
                $table->decimal('grand_total', 10, 2)->after('amenities_total')->default(0);
            }
            if (!Schema::hasColumn('bookings', 'selected_amenities_json')) {
                $table->json('selected_amenities_json')->after('grand_total')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'selected_amenities_json')) {
                $table->dropColumn('selected_amenities_json');
            }
            if (Schema::hasColumn('bookings', 'grand_total')) {
                $table->dropColumn('grand_total');
            }
            if (Schema::hasColumn('bookings', 'amenities_total')) {
                $table->dropColumn('amenities_total');
            }
            if (Schema::hasColumn('bookings', 'base_price')) {
                $table->dropColumn('base_price');
            }
        });
    }
};
