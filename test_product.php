<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create(
    '/test-product',
    'POST',
    [
        'idCategory' => 1,
        'nameProduct' => 'Test Product',
        'priceProduct' => 25.00,
        'quantityProduct' => 10
    ]
);

$response = $kernel->handle($request);

echo $response->getContent();
$kernel->terminate($request, $response);
