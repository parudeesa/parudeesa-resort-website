<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Schema::table('event_inquiries', function (Blueprint $table) {
    if (!Schema::hasColumn('event_inquiries', 'stay_duration')) {
        $table->string('stay_duration')->nullable();
    }
});
echo "Done\n";
