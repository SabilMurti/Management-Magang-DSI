<?php

namespace App\Livewire\Supervisors;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
class SupervisorForm extends Component
{
    public ?User $supervisor = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public $isEditing = false;
    public $pageTitle = 'Tambah Pembimbing';

    protected function rules()
    {
        $emailRule = 'required|email|unique:users,email';
        if ($this->isEditing) {
            $emailRule = 'required|email|unique:users,email,' . $this->supervisor->id;
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
        ];

        if (!$this->isEditing) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function mount(?User $supervisor = null)
    {
        if ($supervisor && $supervisor->exists && $supervisor->role === 'pembimbing') {
            $this->supervisor = $supervisor;
            $this->isEditing = true;
            $this->name = $supervisor->name;
            $this->email = $supervisor->email;
            $this->pageTitle = 'Edit Pembimbing';
        }
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->isEditing) {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $this->supervisor->update($data);
            $message = 'Data pembimbing berhasil diperbarui!';
        } else {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pembimbing',
            ]);
            $message = 'Pembimbing berhasil ditambahkan!';
        }

        session()->flash('success', $message);
        return redirect()->route('supervisors.index');
    }

    #[Title('Form Pembimbing')]
    public function render()
    {
        return view('livewire.supervisors.supervisor-form', [
            'pageTitle' => $this->pageTitle,
        ]);
    }
}
