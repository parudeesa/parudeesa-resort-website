<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$properties = App\Models\Property::all();
foreach($properties as $p) {
    echo $p->name . ' - ' . $p->price . ' - ' . $p->description . "\n";
}
?>