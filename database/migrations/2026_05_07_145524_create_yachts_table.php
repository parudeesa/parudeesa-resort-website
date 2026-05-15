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
        if (!Schema::hasTable('yachts')) {
            Schema::create('yachts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('duration')->nullable(); // e.g., "5 Hours"
            $table->integer('capacity')->nullable(); // e.g., 10
            $table->string('image_url')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yachts');
    }
};
