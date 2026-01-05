<?php

namespace App\Livewire;

use App\Models\Sensor;
use Livewire\Component;
use Carbon\Carbon;

class SensorChart extends Component
{
    public $filter = 'hour';

    public function render()
    {
        // 1. QUERY DATABASE (Biarkan seperti semula)
        $query = Sensor::query();
        switch ($this->filter) {
            case '24hours':
                $query->where('created_at', '>=', Carbon::now()->subDay());
                $limit = 100;
                break;
            case '7days':
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
                $limit = 300;
                break;
            case 'hour':
            default:
                $query->where('created_at', '>=', Carbon::now()->subHour());
                $limit = 60;
                break;
        }

        // Ambil data dan urutkan
        $sensors = $query->latest()->take($limit)->get()->sortBy('created_at');

        $labels = [];
        $voltages = [];
        $currents = [];

        // Simpan waktu data terakhir buat pengecekan
        $lastDataTime = null;

        foreach ($sensors as $s) {
            // Simpan format jam:menit:detik biar kelihatan pergerakannya
            $labels[] = $s->created_at->format('H:i:s');

            $data = $s->data ?? [];
            $voltages[] = $data['voltage'] ?? 0;
            $currents[] = $data['current'] ?? 0;

            $lastDataTime = $s->created_at; // Catat waktu terakhir
        }

        // ============================================================
        // LOGIKA BARU: PAKSA TURUN KE NOL JIKA OFFLINE
        // ============================================================

        if ($lastDataTime) {
            // Cek selisih waktu data terakhir dengan SEKARANG
            $diff = Carbon::parse($lastDataTime)->diffInSeconds(now());

            // Jika data terakhir lebih tua dari 10 detik (artinya alat mati/delay)
            // Kita suntikkan data palsu bernilai 0 di waktu SEKARANG.
            if ($diff > 10) {
                $labels[] = now()->format('H:i:s'); // Label waktu sekarang
                $voltages[] = 0; // Paksa Tegangan 0
                $currents[] = 0; // Paksa Arus 0
            }
        }
        // ============================================================

        // SIAPKAN DATA ARRAY
        $chartData = [
            'labels' => array_values($labels),
            'voltages' => array_values($voltages),
            'currents' => array_values($currents),
        ];

        // Dispatch untuk Update Realtime
        $this->dispatch('update-chart', $chartData);

        return view('livewire.sensor-chart', [
            'chartData' => $chartData
        ]);
    }
}
