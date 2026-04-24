<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$bookings = App\Models\Booking::all();
echo 'Bookings count: ' . $bookings->count() . "\n";
foreach($bookings as $b) {
    echo $b->name . ' - ' . $b->property_id . ' - ' . $b->status . "\n";
}
?>