<?php

namespace App\Livewire\Ekstra;

use Livewire\Component;
use App\Models\Ekstrakurikuler;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $search = '';

    protected $listeners = [
        'ekstraUpdated' => 'refreshData',
    ];

    public function refreshData()
    {
        // Tidak perlu pagination, hanya reload data
    }

    public function render()
    {
        $ekstras = Ekstrakurikuler::where('user_id', Auth::id())
            ->where('nama_ekstrakurikuler', 'like', "%{$this->search}%")
            ->orderBy('nama_ekstrakurikuler')
            ->get();

        return view('livewire.ekstra.index', compact('ekstras'));
    }
}
