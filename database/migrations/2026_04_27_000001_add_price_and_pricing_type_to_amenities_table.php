<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            if (!Schema::hasColumn('amenities', 'price')) {
                $table->decimal('price', 10, 2)->default(0)->after('description');
            }
            if (!Schema::hasColumn('amenities', 'pricing_type')) {
                $table->string('pricing_type')->default('fixed')->after('price');
            }
            if (!Schema::hasColumn('amenities', 'status')) {
                $table->boolean('status')->default(true)->after('pricing_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('amenities', function (Blueprint $table) {
            if (Schema::hasColumn('amenities', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('amenities', 'pricing_type')) {
                $table->dropColumn('pricing_type');
            }
            if (Schema::hasColumn('amenities', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};