<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB; // <--- PASTIKAN ADA INI
use Carbon\Carbon; // <--- PASTIKAN ADA INI

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // =========================================================
    // KAMU WAJIB MENAMBAHKAN BAGIAN DI BAWAH INI KE FILE USER.PHP
    // =========================================================

    /**
     * Accessor untuk mengambil last_activity dari tabel sessions
     */
    public function getLastActivityAttribute()
    {
        // Ambil data session terakhir berdasarkan user_id
        $session = DB::table('sessions')
            ->where('user_id', $this->id)
            ->orderBy('last_activity', 'desc')
            ->first();

        // Jika ada session, return sebagai Carbon object
        if ($session) {
            return Carbon::createFromTimestamp($session->last_activity);
        }

        return null;
    }
}
