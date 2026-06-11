<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden p-4">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-emerald-200/40 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-teal-200/40 rounded-full blur-3xl" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-100/30 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 w-full max-w-md mx-4">
            <div class="text-center mb-8 animate-fade-in">
                <img src="{{ asset('logo-banten.svg') }}" alt="Logo Banten" class="h-20 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Sistem Pemeliharaan Kendaraan</h1>
                <p class="text-gray-500 text-sm mt-1">Biro Umum Sekretariat Daerah Provinsi Banten</p>
            </div>
            <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-200 animate-slide-up">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
