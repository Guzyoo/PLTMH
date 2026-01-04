<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;
use Livewire\WithPagination;

class ActivityLogIndex extends Component
{
    use WithPagination;

    public function render()
    {
        // Ambil data log, urutkan terbaru, load relasi user biar bisa ambil namanya
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view('livewire.activity-log-index', [
            'logs' => $logs
        ]);
    }
}
