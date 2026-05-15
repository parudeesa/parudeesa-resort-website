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
        // Event Cards (Events We Host)
        Schema::create('event_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable(); // Emoji or icon class
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Event Amenities
        Schema::create('event_amenities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Event Gallery
        Schema::create('event_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('category')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Event Steps (Effortless Journey)
        Schema::create('event_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('step_number')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // Event Pricing Features
        Schema::create('event_pricing_features', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_pricing_features');
        Schema::dropIfExists('event_steps');
        Schema::dropIfExists('event_galleries');
        Schema::dropIfExists('event_amenities');
        Schema::dropIfExists('event_cards');
    }
};
