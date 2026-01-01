<div wire:poll.2s class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 w-full">
    
    @foreach($cards as $card)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition duration-300 relative overflow-hidden group">
        
        <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-{{ $card['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
            </svg>
        </div>

        <div class="relative z-10">
            <p class="text-sm font-medium text-slate-500 mb-1">{{ $card['label'] }}</p>
            
            <div class="flex items-baseline gap-1">
                <span class="text-3xl font-bold {{ $card['label'] == 'Getaran (Vibration)' && $card['value'] == 'Aman' ? 'text-green-600' : 'text-slate-900' }}">
                    {{ $card['value'] }}
                </span>
                <span class="text-sm font-semibold text-slate-400">{{ $card['unit'] }}</span>
            </div>

            @if($card['progress'])
                @php
                    $rawValue = (int)str_replace(',', '', $card['value']);
                    $percent = min(($rawValue / 1000) * 100, 100); 
                @endphp
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-3">
                    <div class="bg-{{ $card['color'] }}-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                </div>
            @else
                <div class="mt-2 text-xs font-medium text-slate-500 inline-block px-2 py-0.5 rounded bg-slate-50">
                    {{ $card['status'] }}
                </div>
            @endif

        </div>
    </div>
    @endforeach

</div>