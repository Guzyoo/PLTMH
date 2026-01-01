<div wire:poll.5s>
    @if($isOnline)
        {{-- TAMPILAN ONLINE (Hijau) --}}
        <div class="flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold border border-green-200 transition-all duration-500">
            <span class="w-2 h-2 bg-green-500 rounded-full blink"></span>
            ONLINE
        </div>
    @else
        {{-- TAMPILAN OFFLINE (Abu-abu / Merah) --}}
        <div class="flex items-center gap-2 px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-semibold border border-slate-200 transition-all duration-500">
            <span class="w-2 h-2 bg-red-400 rounded-full"></span>
            OFFLINE
        </div>
    @endif
    
    {{-- CSS untuk animasi kedip-kedip (Blink) --}}
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
        .blink {
            animation: blink 1.5s infinite;
        }
    </style>
</div>