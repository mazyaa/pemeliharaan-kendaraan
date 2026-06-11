<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Pemeliharaan Kendaraan') }} - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="shortcut icon" href="/logo-banten.svg" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        @include('layouts.sidebar')
        <div class="flex-1 flex flex-col lg:ml-64 min-h-screen">
            @include('layouts.navigation')
            <main class="flex-1 p-4 md:p-6 lg:p-8 space-y-6 animate-fade-in">
                @if(session('success'))
                    <input type="hidden" id="flash-success" value="{{ session('success') }}">
                @endif
                @if(session('error'))
                    <input type="hidden" id="flash-error" value="{{ session('error') }}">
                @endif
                @if($errors->any())
                    <input type="hidden" id="flash-validation" value="{{ implode(', ', $errors->all()) }}">
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function confirmDelete(url, message = 'Data akan dihapus secara permanen.') {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#374151',
                iconColor: '#f59e0b',
                customClass: {
                    popup: 'rounded-3xl shadow-xl border border-gray-200',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-red-500 to-rose-600 hover:shadow-lg transition-all',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmSubmit(url, message = 'Yakin ingin mengirim pengajuan ini?') {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#374151',
                iconColor: '#10b981',
                customClass: {
                    popup: 'rounded-3xl shadow-xl border border-gray-200',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-emerald-500 to-green-600 hover:shadow-lg transition-all',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function confirmAction(url, title = 'Konfirmasi', text = 'Yakin ingin melanjutkan?', confirmText = 'Ya') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#374151',
                iconColor: '#10b981',
                customClass: {
                    popup: 'rounded-3xl shadow-xl border border-gray-200',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-br from-emerald-500 to-green-600 hover:shadow-lg transition-all',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    @stack('modals')
    @stack('scripts')
</body>
</html>
