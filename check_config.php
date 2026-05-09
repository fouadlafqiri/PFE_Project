<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "DB: " . config('database.default') . "\n";
echo "Host: " . config('database.connections.mysql.host') . "\n";
echo "DB Name: " . config('database.connections.mysql.database') . "\n";
echo "Username: " . config('database.connections.mysql.username') . "\n";
