<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Device - PLTMH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    {{-- NAVBAR KHUSUS HALAMAN ADMIN --}}
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <a href="{{ url('/') }}" class="flex text-sm font-medium text-slate-500 hover:text-blue-600 transition">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-600 p-2 rounded-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-900">
                            {{ Auth::user()->role === 'admin' ? 'Administrator' : 'User Panel' }}
                        </span>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    {{-- Profil User --}}
                    <div class="flex items-center gap-2">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 uppercase">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <form id="form-logout" method="POST" action="{{ route('logout') }}">
                        @csrf
                        {{-- Ubah type jadi button dan tambah onclick --}}
                        <button type="button" onclick="konfirmasiLogout()" class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 bg-white rounded-lg hover:bg-red-50 transition" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Device Management</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola daftar alat IoT dan kepemilikannya.</p>
            </div>

            {{-- AREA BUTTON --}}
            {{-- Perubahan ada di class div di bawah ini --}}
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto [&>*]:w-full [&>*]:sm:w-auto">

                {{-- LOGIKA PEMBEDA: HANYA ADMIN YANG BISA MANAGE USER --}}
                @if(Auth::user()->role === 'admin')
                {{-- Pastikan di dalam component ini button/a-nya punya class w-full juga jika perlu --}}
                <x-ManageUser />
                <livewire:create-user />
                @endif

                {{-- SEMUA YANG LOGIN (Admin & User) BISA TAMBAH DEVICE --}}
                <livewire:devices.create-device />

                <a href="{{ route('logs.index') }}" class="inline-flex items-center w-full sm:w-auto justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    Log Aktivitas
                </a>

            </div>
        </div>

        {{-- Tabel Device --}}
        <livewire:devices.devices-index />

    </main>

    <script>
        function konfirmasiLogout() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Sesi Anda akan berakhir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // INI KUNCINYA:
                    // Jika user klik "Ya", JS akan mencari form dengan ID 'form-logout'
                    // dan mengirimkannya secara paksa. Laravel akan menerimanya sebagai request POST biasa.
                    document.getElementById('form-logout').submit();
                }
            })
        }
    </script>
    @livewireScripts

</body>

</html>