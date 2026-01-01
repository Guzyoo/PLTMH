<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use Livewire\Component;
use Livewire\Attributes\On; // <--- 1. WAJIB IMPORT INI (Buat Listener)
use Livewire\WithPagination; // <--- 2. WAJIB IMPORT INI (Buat Pagination)
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class DevicesIndex extends Component
{
    // 3. Gunakan Trait Pagination agar halaman 1, 2, dst jalan mulus
    use WithPagination;

    // 4. LISTENER AJAIB
    // Fungsi ini akan otomatis dipanggil saat 'CreateDevice' selesai simpan data.
    // Saat fungsi ini dipanggil, Livewire otomatis me-render ulang tabelnya.
    #[On('device-created')]
    public function refreshTable()
    {
        // Kosong saja tidak apa-apa. 
        // Tujuan utamanya cuma memicu siklus render ulang.
    }

    public function render(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // Pakai latest() biar data baru muncul paling atas
        $devices = Device::with('user')->latest()->paginate(10);

        return view('livewire.devices.devices-index', ['devices' => $devices]);
    }
}
