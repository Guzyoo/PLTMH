<div class="space-y-6">
    
    {{-- BAGIAN 1: FILTER (Dropdown) --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            
            {{-- Filter: Pilih Device --}}
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Device</label>
                <select wire:model.live="device_id" class="w-full text-sm border border-slate-300 rounded-lg focus:ring-blue-500">
                    <option value="">-- Semua Device --</option>
                    @foreach($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter: Rentang Waktu --}}
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Rentang Waktu</label>
                <select wire:model.live="time_range" class="w-full text-sm border-slate-300 border rounded-lg focus:ring-blue-500">
                    <option value="hour">1 Jam Terakhir</option>
                    <option value="24hours">24 Jam Terakhir</option>
                    <option value="7days">7 Hari Terakhir</option>
                    <option value="30days">30 Hari Terakhir (Bulan Ini)</option>
                    <option value="all">Semua Riwayat Data</option>
                </select>
            </div>

            {{-- Loading Indicator --}}
            <div class="w-full md:w-1/3 text-right">
                <span wire:loading class="text-sm text-blue-600 font-medium animate-pulse">
                    Sedang memuat data...
                </span>
            </div>

        </div>
    </div>

    {{-- BAGIAN 2: TABEL DATA --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Tegangan (V)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Arus (A)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Daya (W)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($sensors as $sensor)
                    <tr class="hover:bg-slate-50">
                        {{-- Waktu --}}
                        <td class="px-6 py-4 text-sm text-slate-600 font-mono whitespace-nowrap">
                            {{ $sensor->created_at->format('d M Y, H:i:s') }}
                        </td>
                        
                        {{-- Nama Device --}}
                        <td class="px-6 py-4 text-sm text-slate-900 font-medium">
                            {{ $sensor->device->name ?? '-' }}
                        </td>

                        {{-- Tegangan --}}
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ number_format($sensor->data['voltage'] ?? 0, 1) }} V
                        </td>

                        {{-- Arus --}}
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ number_format($sensor->data['current'] ?? 0, 2) }} A
                        </td>

                        {{-- Daya --}}
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">
                            {{ number_format($sensor->data['power'] ?? 0) }} W
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                            Tidak ada data yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (Tombol Next/Prev) --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $sensors->links() }}
        </div>
    </div>
</div>