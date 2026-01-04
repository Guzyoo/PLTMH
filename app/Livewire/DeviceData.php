<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class DeviceData extends Component
{
    public $isOpen = false;
    public $isDeleting = false; // <--- STATE BARU UNTUK MODAL HAPUS

    public $users;
    public $device_id;
    public $name, $device_type, $device_identifier, $user_id;

    public function mount()
    {
        $this->users = User::all();
    }

    #[On('edit-device')]
    public function loadDevice($id)
    {
        $device = Device::find($id);

        if ($device) {
            $this->device_id = $device->id;
            $this->name = $device->name;
            $this->device_type = $device->device_type;
            $this->device_identifier = $device->device_identifier;
            $this->user_id = $device->user_id;

            $this->isOpen = true;
            $this->isDeleting = false; // Reset status delete saat buka modal
            $this->resetValidation();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->isDeleting = false; // Reset status delete
        $this->reset(['name', 'device_type', 'device_identifier', 'user_id', 'device_id']);
    }

    // --- LOGIKA HAPUS BARU ---

    // 1. Tombol Delete ditekan -> Munculkan Konfirmasi
    public function confirmDelete()
    {
        $this->isDeleting = true;
    }

    // 2. Tombol Batal Delete ditekan -> Kembali ke Form Edit
    public function cancelDelete()
    {
        $this->isDeleting = false;
    }

    // 3. Tombol "Ya, Hapus" ditekan -> Eksekusi Hapus
    public function delete()
    {
        if ($this->device_id) {
            // 1. Ambil data device sebelum dihapus (buat dicatat namanya)
            $device = Device::find($this->device_id);

            if ($device) {
                // 2. CATAT KE LOG AKTIVITAS
                ActivityLog::create([
                    'user_id'     => Auth::id(), // Ini PASTI user yang sedang login/online saat ini
                    'action'      => 'DELETE DEVICE',
                    'description' => 'Menghapus device: ' . $device->name . ' (ID: ' . $device->device_identifier . ')',
                    'ip_address'  => request()->ip(), // Catat IP address buat keamanan tambahan
                ]);

                // 3. Baru hapus datanya
                $device->delete();

                $this->dispatch('device-updated');
                $this->closeModal();

                // Opsional: Beri pesan sukses spesifik
                session()->flash('message', 'Device berhasil dihapus dan aktivitas tercatat.');
            }
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'device_type' => 'required',
            'user_id' => 'required|exists:users,id',
            'device_identifier' => 'required|unique:devices,device_identifier,' . $this->device_id
        ]);

        if ($this->device_id) {
            $device = Device::find($this->device_id);
            $device->update([
                'name' => $this->name,
                'device_type' => $this->device_type,
                'device_identifier' => $this->device_identifier,
                'user_id' => $this->user_id,
            ]);

            $this->dispatch('device-updated');
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.device-data');
    }
}
