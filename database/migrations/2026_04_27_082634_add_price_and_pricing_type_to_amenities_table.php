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
        Schema::table('amenities', function (Blueprint $table) {
            if (!Schema::hasColumn('amenities', 'price')) {
                $table->decimal('price', 10, 2)->after('description')->nullable();
            }
            if (!Schema::hasColumn('amenities', 'pricing_type')) {
                $table->enum('pricing_type', ['per_person', 'fixed'])->after('price')->default('fixed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            if (Schema::hasColumn('amenities', 'pricing_type')) {
                $table->dropColumn('pricing_type');
            }
            if (Schema::hasColumn('amenities', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};
