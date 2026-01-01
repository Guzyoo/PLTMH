<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\Sensor;
use Livewire\Component;
use Livewire\WithPagination; // Wajib import ini buat ganti halaman
use Carbon\Carbon;

class History extends Component
{
    use WithPagination; // Gunakan fitur pagination

    // Variabel Filter
    public $device_id = '';       // Untuk nyimpan pilihan device
    public $time_range = '24hours'; // Default filter: 24 Jam terakhir

    // Reset halaman ke 1 kalau filter berubah
    public function updatedDeviceId()
    {
        $this->resetPage();
    }
    public function updatedTimeRange()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Siapkan Query
        $query = Sensor::with('device');

        // 2. Filter Device (Jika user memilih device tertentu)
        if (!empty($this->device_id)) {
            $query->where('device_id', $this->device_id);
        }

        // 3. Filter Waktu
        switch ($this->time_range) {
            case 'hour':
                $query->where('created_at', '>=', Carbon::now()->subHour());
                break;
            case '24hours':
                $query->where('created_at', '>=', Carbon::now()->subDay());
                break;
            case '7days':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;
            case '30days':
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                break;
                // case 'all' tidak perlu ditulis, dia otomatis ambil semua
        }

        // 4. Ambil Data (Pagination 10 baris per halaman)
        // latest() biar data terbaru muncul paling atas
        $sensors = $query->latest()->paginate(10);

        // 5. Ambil Data Device untuk isi Dropdown
        $devices = Device::all();

        return view('livewire.history', [
            'sensors' => $sensors,
            'devices' => $devices
        ]);
    }
}
