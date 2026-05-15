<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Food Packages Table
        Schema::create('food_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // 2. Event Services Table
        Schema::create('event_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // 3. Update Properties Table
        Schema::table('properties', function (Blueprint $table) {
            if (!Schema::hasColumn('properties', 'weekday_price')) {
                $table->decimal('weekday_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('properties', 'weekend_price')) {
                $table->decimal('weekend_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('properties', 'base_guests')) {
                $table->integer('base_guests')->default(5);
            }
            if (!Schema::hasColumn('properties', 'extra_guest_price')) {
                $table->decimal('extra_guest_price', 10, 2)->default(600);
            }
            if (!Schema::hasColumn('properties', 'max_guests')) {
                $table->integer('max_guests')->default(15);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_packages');
        Schema::dropIfExists('event_services');
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['weekday_price', 'weekend_price', 'base_guests', 'extra_guest_price', 'max_guests']);
        });
    }
};
