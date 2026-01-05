<?php

namespace App\Livewire;

use App\Models\Sensor;
use Livewire\Component;
use Carbon\Carbon; // 1. Wajib import Carbon untuk urus waktu

class DashboardSensor extends Component
{
    public function render()
    {
        $sensor = Sensor::latest()->first();

        // Default: Anggap data kosong/offline dulu
        $data = [];
        $isOnline = false;

        // 2. LOGIKA PENGECEKAN WAKTU
        if ($sensor) {
            $lastUpdate = Carbon::parse($sensor->created_at);

            // Cek apakah data terakhir masuk kurang dari 15 detik yang lalu?
            // Sesuaikan 15 dengan interval pengiriman alatmu (misal alat kirim tiap 5 detik, set ini jadi 10-15)
            if ($lastUpdate->diffInSeconds(now()) <= 15) {
                $data = $sensor->data ?? [];
                $isOnline = true; // Alat dianggap Hidup
            }
        }

        // 3. Susun data (Kalau $isOnline false, otomatis jadi 0 karena default array kosong)
        $cards = [
            [
                'label' => 'Tegangan (Voltage)',
                // Jika data ada isinya ambil, jika tidak (offline) jadi 0
                'value' => number_format($data['voltage'] ?? 0, 1),
                'unit'  => 'V',
                'color' => $isOnline ? 'yellow' : 'gray', // Jadi abu-abu kalau offline
                'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                // Ubah status teks
                'status' => $isOnline ? 'Stabil (220V ±5%)' : 'Device Offline',
                'progress' => false
            ],
            [
                'label' => 'Arus (Current)',
                'value' => number_format($data['current'] ?? 0, 2),
                'unit'  => 'A',
                'color' => $isOnline ? 'blue' : 'gray',
                'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                'status' => $isOnline ? 'Beban Normal' : 'Tidak ada arus',
                'progress' => false
            ],
            [
                'label' => 'Daya (Power)',
                'value' => number_format($data['power'] ?? 0, 0),
                'unit'  => 'W',
                'color' => $isOnline ? 'orange' : 'gray',
                'icon'  => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                'status' => $isOnline ? 'Aktif' : 'Offline',
                'progress' => false
            ],
            [
                'label' => 'Getaran (Vibration)',
                // Logika khusus getaran
                'value' => $isOnline
                    ? (($data['vibration'] ?? 0) > 10 ? 'Bahaya' : 'Aman')
                    : '-', // Strip kalau offline
                'unit'  => '',
                'color' => $isOnline ? 'red' : 'gray',
                'icon'  => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                'status' => $isOnline ? 'Monitoring Aktif' : 'Sensor Mati',
                'progress' => false
            ],
        ];

        return view('livewire.dashboard-sensor', [
            'cards' => $cards
        ]);
    }
}
