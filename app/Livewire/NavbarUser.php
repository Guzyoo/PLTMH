<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; // <--- WAJIB IMPORT INI
use Illuminate\Support\Facades\Auth;

class NavbarUser extends Component
{
    // Ini 'telinga'-nya. Kalau denger teriakan 'user-updated', dia jalan.
    #[On('user-updated')]
    public function refreshUser()
    {
        // Kosong gak apa-apa, tujuannya cuma mancing render ulang
    }

    public function render()
    {
        // Pakai fresh() biar dapet data langsung dari DB, bukan dari Session lama
        $user = Auth::user() ? Auth::user()->fresh() : null;

        return view('livewire.navbar-user', [
            'user' => $user
        ]);
    }
}
