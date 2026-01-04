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

<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    {{-- Panggil Navbar --}}
    <x-navbar />

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER HALAMAN --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Riwayat Data Sensor</h1>
                <p class="text-slate-500 text-sm mt-1">Rekapitulasi lengkap data tegangan & arus.</p>
            </div>
        </div>

        <livewire:history />

    </main>

    <x-footer />

</body>

</html>