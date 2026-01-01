<nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 p-2 rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">PLTMH Monitor</span>
                </div>

                

                <div class="flex items-center gap-4">
                    <div class="flex items-center">
                        <a href="{{ url('/devices') }}" class="text-sm font-medium text-slate-500 hover:text-blue-600 transition">Admin</a>
                    </div>
                    <livewire:device-status />

                    @if (Route::has('login'))
                    <div class="hidden sm:flex gap-2">
                        @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Admin Panel</a>
                        @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Log in</a>
                        @endauth
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>