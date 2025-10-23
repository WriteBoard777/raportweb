<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = [
        'siswaUpdated' => 'refreshData',
    ];

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $siswas = Siswa::where('nama', 'like', "%{$this->search}%")
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.siswa.index', compact('siswas'));
    }
}
