<div wire:poll.5s>

    {{-- ============================================================== --}}
    {{-- BAGIAN 1: NOTIFIKASI MELAYANG (TOAST / PUSH STYLE) --}}
    {{-- ============================================================== --}}
    <div class="fixed top-24 z-[100] flex flex-col gap-3 pointer-events-none 
                inset-x-0 px-4 w-full 
                sm:inset-auto sm:right-5 sm:max-w-sm">

        @foreach($alerts as $index => $alert)
        <div wire:key="toast-{{ $index }}"
            x-data="{ show: true }"
            x-show="show"
            x-init="$watch('show', value => { if (value === false) setTimeout(() => show = true, 30000) })"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            class="pointer-events-auto w-full bg-white shadow-2xl rounded-lg overflow-hidden ring-1 ring-black ring-opacity-5 
                 {{ $alert['type'] == 'danger' ? 'border-l-4 border-red-500' : 'border-l-4 border-yellow-500' }}">

            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if($alert['type'] == 'danger')
                        <div class="relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <svg class="relative h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        @else
                        <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-bold {{ $alert['type'] == 'danger' ? 'text-red-900' : 'text-yellow-900' }}">
                            {{ $alert['title'] }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $alert['message'] }}
                        </p>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button @click="show = false" type="button" class="inline-flex rounded-md bg-white text-slate-400 hover:text-slate-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ============================================================== --}}
    {{-- BAGIAN 2: BANNER STATIS (MENEMPEL DI DASHBOARD) --}}
    {{-- ============================================================== --}}
    <div class="space-y-4 mb-6 w-full">
        @foreach($alerts as $index => $alert)
        <div wire:key="banner-{{ $index }}"
            class="rounded-lg p-4 border-l-4 shadow-sm flex items-start gap-3 w-full
                 {{ $alert['type'] == 'danger' ? 'bg-red-50 border-red-500 text-red-700' : 'bg-yellow-50 border-yellow-500 text-yellow-700' }}">

            {{-- Icon Banner --}}
            <div class="flex-shrink-0 mt-0.5">
                @if($alert['type'] == 'danger')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                @endif
            </div>

            {{-- Text Banner --}}
            <div class="flex-1">
                <h3 class="font-bold text-sm uppercase tracking-wide">{{ $alert['title'] }}</h3>
                <p class="text-sm mt-1 opacity-90">{{ $alert['message'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

</div>