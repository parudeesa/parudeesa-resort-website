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
        Schema::table('event_inquiries', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            
            if (!Schema::hasColumn('event_inquiries', 'stay_guests')) {
                $table->integer('stay_guests')->nullable()->after('need_stay');
            }
            
            if (!Schema::hasColumn('event_inquiries', 'event_duration')) {
                $table->string('event_duration')->nullable();
            }
            
            if (!Schema::hasColumn('event_inquiries', 'stay_duration')) {
                $table->string('stay_duration')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_inquiries', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->dropColumn(['stay_guests', 'event_duration']);
        });
    }
};
