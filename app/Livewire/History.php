<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\Sensor;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class History extends Component
{
    use WithPagination;

    // Filter
    public $device_id = '';
    public $time_range = '24 Jam';

    // Variabel Delete Satu Data
    public $confirmingDelete = false;
    public $deleteId = null;

    // === VARIABEL BARU: DELETE ALL ===
    public $confirmingDeleteAll = false;

    public function updatedDeviceId()
    {
        $this->resetPage();
    }
    public function updatedTimeRange()
    {
        $this->resetPage();
    }

    // --- LOGIC HAPUS SATUAN (LAMA) ---
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function deleteSensor()
    {
        $sensor = Sensor::find($this->deleteId);
        if ($sensor) {
            $sensor->delete();
            session()->flash('message', 'Data berhasil dihapus.');
        }
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    // --- LOGIC HAPUS SEMUA (BARU) ---

    // 1. Buka Modal Hapus Semua
    public function confirmDeleteAll()
    {
        $this->confirmingDeleteAll = true;
    }

    // 2. Batal Hapus Semua
    public function cancelDeleteAll()
    {
        $this->confirmingDeleteAll = false;
    }

    // 3. Eksekusi Hapus Semua (Sesuai Filter)
    public function deleteAllSensors()
    {
        // Kita gunakan logika query yang SAMA dengan render
        // Agar yang terhapus hanya yang sedang dilihat user (jika difilter)
        $query = Sensor::query();

        if (!empty($this->device_id)) {
            $query->where('device_id', $this->device_id);
        }

        switch ($this->time_range) {
            case '1 Jam':
                $query->where('created_at', '>=', Carbon::now()->subHour());
                break;
            case '24 Jam':
                $query->where('created_at', '>=', Carbon::now()->subDay());
                break;
            case '7 Hari':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;
            case '30 Hari':
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                break;
        }

        // Hapus massal
        $count = $query->delete();

        session()->flash('message', "Berhasil menghapus {$count} data sekaligus.");
        $this->confirmingDeleteAll = false;
        $this->resetPage(); // Reset ke halaman 1
    }

    public function render()
    {
        // Query Render
        $query = Sensor::with('device');

        if (!empty($this->device_id)) {
            $query->where('device_id', $this->device_id);
        }

        switch ($this->time_range) {
            case '1 Jam':
                $query->where('created_at', '>=', Carbon::now()->subHour());
                break;
            case '24 Jam':
                $query->where('created_at', '>=', Carbon::now()->subDay());
                break;
            case '7 Hari':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                break;
            case '30 Hari':
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
                break;
        }

        $sensors = $query->latest()->paginate(10);
        $devices = Device::all();

        return view('livewire.history', [
            'sensors' => $sensors,
            'devices' => $devices
        ]);
    }
}
