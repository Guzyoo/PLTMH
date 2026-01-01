<div class="space-y-6 relative">

    {{-- 1. ALERT / TOAST NOTIFICATION --}}
    @if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="fixed top-24 right-5 z-[100] flex items-center w-full max-w-xs p-4 space-x-3 text-green-800 bg-green-50 rounded-lg shadow-lg border border-green-200" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="text-sm font-semibold">{{ session('message') }}</div>
    </div>
    @endif

    {{-- 2. BAGIAN FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="flex flex-col md:flex-row gap-4 items-end justify-between">

            <div class="flex flex-col md:flex-row gap-4 w-full md:w-3/4">
                {{-- Filter Device --}}
                <div class="w-full md:w-1/2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pilih Device</label>
                    <select wire:model.live="device_id" class="w-full text-sm border border-slate-300 rounded-lg focus:ring-blue-500">
                        <option value="">-- Semua Device --</option>
                        @foreach($devices as $device)
                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Waktu --}}
                <div class="w-full md:w-1/2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Rentang Waktu</label>
                    <select wire:model.live="time_range" class="w-full text-sm border-slate-300 border rounded-lg focus:ring-blue-500">
                        <option value="1 Jam">1 Jam Terakhir</option>
                        <option value="24 Jam">24 Jam Terakhir</option>
                        <option value="7 Hari">7 Hari Terakhir</option>
                        <option value="30 Hari">30 Hari Terakhir</option>
                        <option value="Semua Data">Semua Riwayat Data</option>
                    </select>
                </div>
            </div>

            {{-- Bagian Kanan: Loading & Tombol Hapus Semua --}}
            <div class="w-full md:w-1/4 flex flex-col items-end gap-2">
                <span wire:loading class="text-xs text-blue-600 font-medium animate-pulse">Sedang memuat...</span>

                {{-- TOMBOL HAPUS SEMUA (Hanya Muncul Jika Login) --}}
                @auth
                <button wire:click="confirmDeleteAll" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 rounded-lg font-semibold text-xs text-red-600 uppercase tracking-widest hover:bg-red-100 active:bg-red-200 focus:outline-none focus:border-red-300 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Semua Data
                </button>
                @endauth
            </div>
        </div>
    </div>

    {{-- 3. TABEL DATA (Sama seperti sebelumnya) --}}
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
                        @auth
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Opsi</th>
                        @endauth
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($sensors as $sensor)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm text-slate-600 font-mono whitespace-nowrap">{{ $sensor->created_at->format('d M Y, H:i:s') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-900 font-medium">{{ $sensor->device->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($sensor->data['voltage'] ?? 0, 1) }} V</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($sensor->data['current'] ?? 0, 2) }} A</td>
                        <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ number_format($sensor->data['power'] ?? 0) }} W</td>
                        @auth
                        <td class="px-6 py-4 text-center">
                            <button wire:click="confirmDelete({{ $sensor->id }})" class="p-2 bg-slate-50 text-slate-400 rounded-lg hover:bg-red-50 hover:text-red-600 transition" title="Hapus Data Ini">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                        @endauth
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400">Tidak ada data ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $sensors->links() }}</div>
    </div>

    {{-- 4. MODAL KONFIRMASI HAPUS SATUAN --}}
    @if($confirmingDelete)
    <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm transition-opacity"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Hapus Data?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah Anda yakin menghapus 1 data ini?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button" wire:click="deleteSensor" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Hapus</button>
                    <button type="button" wire:click="cancelDelete" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 5. MODAL KONFIRMASI HAPUS SEMUA (BARU) --}}
    @if($confirmingDeleteAll)
    <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-red-900 bg-opacity-20 backdrop-blur-sm transition-opacity"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl ring-1 ring-red-500 transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-bold leading-6 text-red-600" id="modal-title">PERINGATAN: Hapus Semua Data?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Anda akan menghapus data sensor sesuai filter yang aktif: <br>

                                    {{-- LOGIKA BARU: Cari nama device berdasarkan ID, jika tidak ada ID berarti 'Semua Device' --}}
                                    Device: <b>{{ $device_id ? $devices->firstWhere('id', $device_id)->name : 'Semua Device' }}</b> <br>

                                    Waktu: <b>{{ $time_range }}</b> <br><br>
                                    Tindakan ini akan menghapus <b>banyak data sekaligus</b> dan tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <button type="button" wire:click="deleteAllSensors" class="inline-flex w-full justify-center rounded-md bg-red-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 sm:ml-3 sm:w-auto">
                        Ya, Hapus Semuanya
                    </button>
                    <button type="button" wire:click="cancelDeleteAll" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>