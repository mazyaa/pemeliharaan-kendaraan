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
<body class="font-sans antialiased bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden p-4">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/5 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 w-full max-w-md mx-4">
            <div class="text-center mb-8 animate-fade-in">
                <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center mx-auto mb-4 shadow-2xl shadow-emerald-500/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Sistem Pemeliharaan Kendaraan</h1>
                <p class="text-gray-400 text-sm mt-1">Biro Umum Sekretariat Daerah Provinsi Banten</p>
            </div>
            <div class="glass rounded-3xl p-8 shadow-2xl animate-slide-up">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
