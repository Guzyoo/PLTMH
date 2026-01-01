<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard IoT PLTMH</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <x-navbar/>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Real-time Overview</h1>
                <p class="text-slate-500 text-sm mt-1">Data pemantauan sensor PZEM-004T & Turbin.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <p class="text-xs text-slate-400 text-right">Terakhir update:</p>
                <p class="text-sm font-medium text-slate-700 font-mono">{{ now()->format('H:i:s d M Y') }}</p>
            </div>
        </div>

        <livewire:dashboard-sensor />

        <livewire:sensor-chart />

        <div class="flex justify-end">
            <a href="{{ url('/history') }}" class="group relative inline-flex items-center justify-center px-8 py-3 text-base font-semibold text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 shadow-lg shadow-blue-500/30">
                <span>Lihat Riwayat Lengkap</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

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