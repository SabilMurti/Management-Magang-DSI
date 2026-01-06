<?php

namespace App\Livewire\Supervisors;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Daftar Pembimbing')]
class SupervisorIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteSupervisor($id)
    {
        $user = User::findOrFail($id);
        
        // Check if supervisor has any interns assigned
        if ($user->supervisedInterns()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus pembimbing karena masih memiliki siswa magang yang ditugaskan!');
            return;
        }
        
        $user->delete();
        session()->flash('success', 'Pembimbing berhasil dihapus!');
    }

    public function render()
    {
        $query = User::where('role', 'pembimbing')
            ->withCount('supervisedInterns');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $supervisors = $query->latest()->paginate(10);

        return view('livewire.supervisors.supervisor-index', compact('supervisors'));
    }
}
