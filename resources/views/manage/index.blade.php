<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - PLTMH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
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
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <livewire:manage-user />

    </main>

    @livewireScripts
</body>

</html>