<nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO KIRI (Klik Logo Balik ke Dashboard) --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="bg-blue-600 p-2 rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">PLTMH Monitor</span>
                </a>
            </div>

            {{-- MENU KANAN --}}
            <div class="flex items-center gap-4">

                {{-- Status Device (Selalu Muncul untuk Siapapun) --}}
                <livewire:device-status />


                @guest

                {{-- Tombol Admin Area (Mengarah ke Login juga) --}}
                <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-4 py-2 text-base font-semibold text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-500/30">
                    <span>Admin Area</span>
                </a>

                @else
                {{-- TAMPILAN UNTUK YANG SUDAH LOGIN --}}
                <div class="flex items-center gap-3">
                    <div class="hidden md:block text-right mr-2">
                        <span class="block text-xs text-slate-400">Login sebagai:</span>
                        <span class="block text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                    </div>

                    {{-- Tombol Masuk ke Halaman Devices --}}
                    <a href="{{ route('devices.index') }}" class="text-sm font-medium text-blue-600 hover:underline border border-blue-100 bg-blue-50 px-3 py-1.5 rounded-lg">
                        Kelola Device
                    </a>

                    {{-- Form Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 bg-white rounded-lg hover:bg-red-50 transition" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endguest

            </div>
        </div>
    </div>
</nav>