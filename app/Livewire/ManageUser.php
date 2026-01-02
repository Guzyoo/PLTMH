<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class ManageUser extends Component
{
    use WithPagination;

    public $user_id;
    public $name;
    public $email;

    // State untuk Modal
    public $isEditing = false;
    public $isDeleting = false; // State untuk modal hapus
    public $deleteId = null;    // Menyimpan ID sementara yg mau dihapus

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
    ];

    public function render()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.manage-user', ['users' => $users]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();
        if ($this->user_id) {
            User::find($this->user_id)->update(['name' => $this->name]);
            session()->flash('message', 'Data User berhasil diperbarui.');
            $this->cancel();
        }
    }

    // 1. Munculkan Modal Konfirmasi
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->isDeleting = true;
    }

    // 2. Eksekusi Hapus (Dipanggil dari Modal)
    public function delete()
    {
        if ($this->deleteId == auth()->id()) {
            session()->flash('error', 'Tidak dapat menghapus akun sendiri.');
            $this->cancel();
            return;
        }

        $user = User::find($this->deleteId);
        if ($user) {
            $user->delete();
            session()->flash('message', 'User berhasil dihapus.');
        } else {
            session()->flash('error', 'User tidak ditemukan.');
        }

        $this->cancel(); // Tutup modal & reset
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->isDeleting = false; // Reset state delete
        $this->deleteId = null;    // Reset ID
        $this->reset(['user_id', 'name', 'email']);
    }
}
