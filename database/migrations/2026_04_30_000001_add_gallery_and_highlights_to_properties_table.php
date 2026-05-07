<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (! Schema::hasColumn('properties', 'gallery_images')) {
                $table->json('gallery_images')->nullable()->after('image_url');
            }

            if (! Schema::hasColumn('properties', 'highlights')) {
                $table->json('highlights')->nullable()->after('gallery_images');
            }
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'highlights')) {
                $table->dropColumn('highlights');
            }

            if (Schema::hasColumn('properties', 'gallery_images')) {
                $table->dropColumn('gallery_images');
            }
        });
    }
};
