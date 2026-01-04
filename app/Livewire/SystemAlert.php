<?php

namespace App\Livewire;

use App\Models\Sensor;
use Livewire\Component;
use Carbon\Carbon;

class SystemAlert extends Component
{
    public function render()
    {
        $alerts = [];

        // 1. Ambil Data Terakhir
        $latest = Sensor::latest()->first();

        if (!$latest) {
            // Kasus langka: Belum ada data sama sekali di database
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Menunggu Data',
                'message' => 'Belum ada data sensor yang masuk ke sistem.'
            ];
        } else {
            // 2. CEK KONEKSI (OFFLINE)
            // Jika data terakhir lebih tua dari 2 menit, anggap OFFLINE
            $lastUpdate = Carbon::parse($latest->created_at);
            if ($lastUpdate->diffInMinutes(now()) > 2) {
                $alerts[] = [
                    'type' => 'danger', // Merah
                    'title' => 'SISTEM OFFLINE',
                    'message' => 'Perangkat tidak mengirim data lebih dari 2 menit. Periksa koneksi internet atau daya alat.'
                ];
            } else {
                // Jika Online, baru kita cek Tegangannya (Voltage)

                // Ambil nilai voltage dari JSON
                $voltage = $latest->data['voltage'] ?? 0;

                // 3. CEK TEGANGAN TINGGI (OVERVOLTAGE)
                if ($voltage > 240) {
                    $alerts[] = [
                        'type' => 'danger',
                        'title' => 'TEGANGAN TINGGI (BAHAYA)',
                        'message' => "Tegangan mencapai {$voltage}V! Berisiko merusak peralatan elektronik."
                    ];
                }
                // 4. CEK TEGANGAN RENDAH (UNDERVOLTAGE)
                elseif ($voltage < 200 && $voltage > 0) {
                    $alerts[] = [
                        'type' => 'warning', // Kuning
                        'title' => 'Tegangan Rendah',
                        'message' => "Tegangan drop ke {$voltage}V. Kinerja turbin mungkin tidak optimal."
                    ];
                }
            }
        }

        return view('livewire.system-alert', [
            'alerts' => $alerts
        ]);
    }
}
