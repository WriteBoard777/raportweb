<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = [
        'siswaUpdated' => 'refreshData',
    ];

    /**
     * Reset pagination saat data diperbarui
     */
    public function refreshData()
    {
        $this->resetPage();
    }

    /**
     * Render daftar siswa berdasarkan user login
     */
    public function render()
    {
        $userId = Auth::id();

        $siswas = Siswa::where('user_id', $userId)
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', "%{$this->search}%")
                      ->orWhere('nisn', 'like', "%{$this->search}%")
                      ->orWhere('nis', 'like', "%{$this->search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.siswa.index', compact('siswas'));
    }
}
