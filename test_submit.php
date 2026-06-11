<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/admin/users', 'POST', [
    'name' => 'Test User',
    'email' => 'test2@example.com',
    'nip' => '1234567890',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'role_id' => 1,
    'position' => 'Staff',
    'phone' => '081234567890',
    'is_active' => '1',
]);

$user = \App\Models\User::find(1);
$app->make('auth')->login($user);

$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Redirect: " . $response->headers->get('Location') . "\n";
echo "Session success: " . session('success') . "\n";
