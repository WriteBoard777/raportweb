<?php

namespace App\Livewire\Nilai;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $mapelId;
    public $activeMapels;

    protected $listeners = ['nilaiUpdated' => 'refreshData'];

    public function mount()
    {
        $userId = Auth::id();

        // 🔹 Ambil mapel yang aktif milik user login
        $this->activeMapels = Mapel::whereHas('users', fn($q) => $q->where('user_id', $userId))
            ->orderBy('nama_mapel')
            ->get();

        $this->mapelId = $this->activeMapels->first()?->id ?? null;
    }

    public function updatedMapelId()
    {
        $this->resetPage();
    }

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

        // 🔹 Ambil nilai sesuai mapel terpilih
        $nilaiData = collect();
        if ($this->mapelId) {
            $nilaiData = Nilai::where('mapel_id', $this->mapelId)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        return view('livewire.nilai.index', [
            'siswas' => $siswas,
            'nilaiData' => $nilaiData,
        ]);
    }
}
