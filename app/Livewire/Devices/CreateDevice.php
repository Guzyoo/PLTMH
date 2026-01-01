<?php

namespace App\Livewire\Devices;

use App\Models\User;
use App\Models\Device;
use Livewire\Component;

class CreateDevice extends Component
{
    // Variabel untuk Modal
    public $isOpen = false;

    // Variabel Data
    public $users;
    public $user_id, $name, $device_type, $device_identifier;

    public function mount()
    {
        $this->users = User::all();
    }

    // Fungsi Buka Modal
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation(); // Hapus pesan error lama
    }

    // Fungsi Tutup Modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'device_type', 'device_identifier', 'user_id']);
    }

    public function submit()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|min:3',
            'device_type' => 'required',
            'device_identifier' => 'required|unique:devices,device_identifier'
        ]);

        Device::create([
            'user_id' => $this->user_id,
            'name' => $this->name,
            'device_type' => $this->device_type,
            'device_identifier' => $this->device_identifier,
        ]);

        // Kirim sinyal ke komponen lain (misal tabel) agar refresh
        $this->dispatch('device-created');

        // Tutup modal
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.devices.create-device');
    }
}
