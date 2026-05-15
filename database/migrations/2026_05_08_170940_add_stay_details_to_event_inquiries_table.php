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
            if (!Schema::hasColumn('event_inquiries', 'num_rooms')) {
                $table->integer('num_rooms')->nullable()->after('need_stay');
            }
            if (!Schema::hasColumn('event_inquiries', 'room_type')) {
                $table->string('room_type')->nullable()->after('num_rooms');
            }
            if (!Schema::hasColumn('event_inquiries', 'check_in')) {
                $table->date('check_in')->nullable()->after('room_type');
            }
            if (!Schema::hasColumn('event_inquiries', 'check_out')) {
                $table->date('check_out')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('event_inquiries', 'stay_duration')) {
                $table->string('stay_duration')->nullable()->after('check_out');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_inquiries', function (Blueprint $table) {
            $table->dropColumn(['num_rooms', 'room_type', 'check_in', 'check_out', 'stay_duration']);
        });
    }
};
