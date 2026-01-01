<?php

namespace App\Livewire;

use App\Models\Sensor;
use Livewire\Component;

class DashboardSensor extends Component
{
    public function render()
    {
        $sensor = Sensor::latest()->first();
        $data = $sensor->data ?? []; // Ambil kolom JSON 'data'

        // 2. Susun data biar siap tampil (Mapping DB ke Tampilan)
        $cards = [
            [
                'label' => 'Tegangan (Voltage)',
                'value' => number_format($data['voltage'] ?? 0, 1), // AMBIL DARI DB
                'unit'  => 'V',
                'color' => 'yellow',
                'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                'status' => 'Stabil (220V ±5%)',
                'progress' => false
            ],
            [
                'label' => 'Arus (Current)',
                'value' => number_format($data['current'] ?? 0, 2), // AMBIL DARI DB
                'unit'  => 'A',
                'color' => 'blue',
                'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                'status' => 'Beban Normal',
                'progress' => false
            ],
            [
                'label' => 'Daya (Power)',
                'value' => number_format($data['power'] ?? 0, 0), // AMBIL DARI DB (Pasti 330)
                'unit'  => 'W',
                'color' => 'orange',
                'icon'  => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                'status' => null,
                'progress' => false
            ],
            [
                'label' => 'Getaran (Vibration)',
                'value' => ($data['vibration'] ?? 0) > 10 ? 'Bahaya' : 'Aman', // LOGIKA DB
                'unit'  => '',
                'color' => 'red',
                'icon'  => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                'status' => 'Tidak ada anomali',
                'progress' => false
            ],
        ];
        return view('livewire.dashboard-sensor', [
            'cards' => $cards
        ]);
    }
}
