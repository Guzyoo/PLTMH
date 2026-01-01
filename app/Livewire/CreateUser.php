<?php


namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class CreateUser extends Component
{
    public $isOpen = false;

    public $name, $email, $password;

    // Function Open Modal
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }

    // Function Close Modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'email', 'password']);
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->dispatch('user-created');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.create-user');
    }
}
