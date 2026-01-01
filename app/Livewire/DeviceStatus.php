<?php

namespace App\Livewire;

use App\Models\Sensor;
use Livewire\Component;

class DeviceStatus extends Component
{
    public function render()
    {
        // 1. Ambil data terakhir
        $latest = Sensor::latest()->first();

        // 2. LOGIKA ONLINE:
        // Jika ada data DAN data itu umurnya kurang dari 2 menit yang lalu
        $isOnline = false;
        if ($latest) {
            // diffInMinutes menghitung selisih waktu sekarang dengan waktu data masuk
            $isOnline = $latest->created_at->diffInMinutes(now()) < 2;
        }

        return view('livewire.device-status', [
            'isOnline' => $isOnline
        ]);
    }
}
