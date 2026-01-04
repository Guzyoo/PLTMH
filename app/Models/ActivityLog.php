<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = []; // Izinkan semua kolom diisi

    // Relasi ke User biar tau siapa namanya nanti
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
