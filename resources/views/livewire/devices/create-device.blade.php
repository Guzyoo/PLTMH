<div> <button type="button" wire:click="openModal" class="inline-flex items-center sm:w-auto w-full justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Device
    </button>

    @if($isOpen)

    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">

        <div style="background-color: white; width: 100%; max-width: 500px; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">

            <form wire:submit.prevent="submit">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4 border-b pb-2">
                        Tambah Device Baru
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pemilik (User)</label>
                            <select wire:model="user_id" class="w-full border border-slate-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Alat</label>
                            <input type="text" wire:model="name" class="w-full border border-slate-300 rounded-md p-2" placeholder="Contoh: Sensor Kebun">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tipe Device</label>
                            <select wire:model="device_type" class="w-full border border-slate-300 rounded-md p-2">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="ESP32">ESP32</option>
                                <option value="ESP8266">ESP8266</option>
                                <option value="Raspberry Pi">Raspberry Pi</option>
                            </select>
                            @error('device_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Device ID</label>
                            <input type="text" wire:model="device_identifier" class="w-full border border-slate-300 rounded-md p-2" placeholder="Contoh: SN-123">
                            @error('device_identifier') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm">
                        Simpan Data
                    </button>
                    <button type="button" wire:click="closeModal" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium py-2 px-4 rounded-lg">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif

</div>