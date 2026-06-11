<?php
$request = Illuminate\Http\Request::create('/admin/users', 'POST', [
    'name' => 'Test User Tink',
    'email' => 'tink2@example.com',
    'nip' => '1234567890',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'role_id' => 1,
    'position' => 'Staff',
    'phone' => '081234567890',
    'is_active' => '1',
]);
$request->setSession(app('session')->driver());
app('session')->driver()->start();
auth()->login(\App\Models\User::find(1));
$response = app(Illuminate\Contracts\Http\Kernel::class)->handle($request);
echo 'Status: ' . $response->getStatusCode() . "\n";
echo 'Location: ' . $response->headers->get('Location') . "\n";
echo 'Session success: ' . session('success') . "\n";
