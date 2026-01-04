<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard PLTMH' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Setup Body agar Footer selalu di bawah (Sticky Footer) --}}

<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    {{-- Panggil Navbar yang sudah kamu punya --}}
    <x-navbar />

    {{-- SLOT: Ini tempat Livewire menyuntikkan konten halamannya --}}
    <main class="flex-grow w-full">
        {{ $slot }}
    </main>

    {{-- Footer --}}
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