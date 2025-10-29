<?php

namespace App\Livewire\Absen;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['absenUpdated' => 'refreshData'];

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id();

        // 🔹 Hanya siswa milik user login
        $siswas = Siswa::where('user_id', $userId)
            ->when($this->search, fn($q) =>
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nisn', 'like', "%{$this->search}%")
                  ->orWhere('nis', 'like', "%{$this->search}%")
            )
            ->orderBy('nama')
            ->paginate(10);

        // 🔹 Ambil data absen siswa tersebut
        $absenData = Absen::where('user_id', $userId)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        return view('livewire.absen.index', [
            'siswas' => $siswas,
            'absenData' => $absenData,
        ]);
    }
}
