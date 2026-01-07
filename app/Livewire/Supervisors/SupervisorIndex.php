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

    // Bulk action properties
    public $selectedSupervisors = [];
    public $selectAll = false;
    public $bulkAction = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetBulkSelection();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSupervisors = $this->getFilteredQuery()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedSupervisors = [];
        }
    }

    public function resetBulkSelection()
    {
        $this->selectedSupervisors = [];
        $this->selectAll = false;
        $this->bulkAction = '';
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

    public function executeBulkAction()
    {
        if (empty($this->selectedSupervisors)) {
            session()->flash('error', 'Pilih minimal satu data terlebih dahulu!');
            return;
        }

        switch ($this->bulkAction) {
            case 'delete':
                $this->bulkDelete();
                break;
            default:
                session()->flash('error', 'Pilih aksi yang valid!');
                return;
        }

        $this->resetBulkSelection();
    }

    public function bulkDelete()
    {
        $supervisors = User::whereIn('id', $this->selectedSupervisors)->withCount('supervisedInterns')->get();
        $deleted = 0;
        $skipped = 0;

        foreach ($supervisors as $supervisor) {
            if ($supervisor->supervised_interns_count > 0) {
                $skipped++;
                continue;
            }
            $supervisor->delete();
            $deleted++;
        }

        if ($skipped > 0) {
            session()->flash('warning', "{$deleted} pembimbing dihapus, {$skipped} dilewati karena masih memiliki siswa magang.");
        } else {
            session()->flash('success', "{$deleted} pembimbing berhasil dihapus!");
        }
    }

    private function getFilteredQuery()
    {
        $query = User::where('role', 'pembimbing')
            ->withCount('supervisedInterns');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        return $query;
    }

    public function render()
    {
        $supervisors = $this->getFilteredQuery()->latest()->paginate(10);

        return view('livewire.supervisors.supervisor-index', compact('supervisors'));
    }
}
