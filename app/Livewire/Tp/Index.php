<?php

namespace App\Livewire\Tp;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tp;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['tpUpdated' => 'refreshData'];

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id();

        $tps = Tp::where('user_id', $userId)
            ->whereHas('mapel', function ($query) {
                $query->where('nama_mapel', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.tp.index', compact('tps'));
    }
}
