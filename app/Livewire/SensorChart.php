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
        // ... (LOGIKA QUERY JANGAN DIUBAH, SAMA SEPERTI SEBELUMNYA) ...
        // ... switch case filter ...

        // Pastikan logic query kamu tetap ada disini
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

        $sensors = $query->latest()->take($limit)->get()->sortBy('created_at');

        $labels = [];
        $voltages = [];
        $currents = [];

        foreach ($sensors as $s) {
            $labels[] = $s->created_at->format('H:i');
            $data = $s->data ?? [];
            $voltages[] = $data['voltage'] ?? 0;
            $currents[] = $data['current'] ?? 0;
        }

        // SIAPKAN DATA ARRAY
        $chartData = [
            'labels' => array_values($labels),
            'voltages' => array_values($voltages),
            'currents' => array_values($currents),
        ];

        // 1. Dispatch untuk Update (Polling)
        $this->dispatch('update-chart', $chartData);

        // 2. Kirim Data Awal ke View (Supaya langsung muncul pas load)
        return view('livewire.sensor-chart', [
            'chartData' => $chartData
        ]);
    }
}
