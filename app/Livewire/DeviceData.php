<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;
use Livewire\Attributes\On; // Penting buat komunikasi antar component

class DeviceData extends Component
{
    public $isOpen = false;
    public $users;

    // Data Form
    public $device_id; // Buat nyimpen ID yang sedang diedit
    public $name, $device_type, $device_identifier, $user_id;

    public function mount()
    {
        $this->users = User::all();
    }

    // 1. LISTENER: Menunggu tombol Edit di tabel diklik
    #[On('edit-device')]
    public function loadDevice($id)
    {
        $device = Device::find($id);

        if ($device) {
            // Isi form dengan data device yang dipilih
            $this->device_id = $device->id;
            $this->name = $device->name;
            $this->device_type = $device->device_type;
            $this->device_identifier = $device->device_identifier;
            $this->user_id = $device->user_id;

            // Buka Modal
            $this->isOpen = true;
            $this->resetValidation();
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'device_type', 'device_identifier', 'user_id', 'device_id']);
    }

    // 2. FUNGSI UPDATE DATA
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'device_type' => 'required',
            'user_id' => 'required|exists:users,id',
            // Identifier harus unik, KECUALI untuk device ini sendiri
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

            // Kirim sinyal ke Tabel buat refresh
            $this->dispatch('device-updated');
            $this->closeModal();
        }
    }

    // 3. FUNGSI DELETE DATA
    public function delete()
    {
        if ($this->device_id) {
            Device::find($this->device_id)->delete();

            // Kirim sinyal ke Tabel buat refresh
            $this->dispatch('device-updated');
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.device-data');
    }
}
