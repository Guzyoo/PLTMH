<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Data - Dashboard IoT PLTMH</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    {{-- Panggil Navbar --}}
    <x-navbar/>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            
            {{-- Tombol Kembali (Arrow ke Kiri) --}}
            <div>
                <a href="{{ url('/') }}" class="group relative inline-flex items-center justify-center px-2 py-3 text-base font-semibold text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </div>


            <div class="text-right">
                <h1 class="text-2xl font-bold text-slate-900">Riwayat Data Sensor</h1>
                <p class="text-slate-500 text-sm mt-1">Rekapitulasi lengkap data tegangan & arus.</p>
            </div>
        </div>

        <livewire:history />

    </main>

    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-400 text-sm">© 2024 Innovillage PLTMH Project. All rights reserved.</p>
            <div class="flex gap-4">
                <span class="text-slate-400 text-xs">System Version 1.0.0</span>
            </div>
        </div>
    </footer>

</body>

</html>