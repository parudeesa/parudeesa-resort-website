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
        Schema::table('yachts', function (Blueprint $table) {
            if (Schema::hasColumn('yachts', 'image_url')) {
                $table->renameColumn('image_url', 'image');
            }
        });

        Schema::table('amenities', function (Blueprint $table) {
            if (Schema::hasColumn('amenities', 'image_url')) {
                $table->renameColumn('image_url', 'image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yachts', function (Blueprint $table) {
            if (Schema::hasColumn('yachts', 'image')) {
                $table->renameColumn('image', 'image_url');
            }
        });

        Schema::table('amenities', function (Blueprint $table) {
            if (Schema::hasColumn('amenities', 'image')) {
                $table->renameColumn('image', 'image_url');
            }
        });
    }
};
