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
    public $mapelId;         // mapel yang dipilih di combo box
    public $activeMapels;    // list mapel aktif user

    protected $listeners = ['nilaiUpdated' => 'refreshData'];

    public function mount()
    {
        $userId = Auth::id();

        // Ambil mapel yang aktif untuk user
        $this->activeMapels = Mapel::orderBy('nama_mapel')
            ->get()
            ->filter(function ($mapel) use ($userId) {
                return DB::table('mapel_user')
                    ->where('user_id', $userId)
                    ->where('mapel_id', $mapel->id)
                    ->exists();
            });

        $this->mapelId = $this->activeMapels->first()?->id ?? null;
    }

    // 🔹 Reset halaman ketika mapel diubah
    public function updatedMapelId($value)
    {
        $this->resetPage();
    }

    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Ambil data siswa sesuai pencarian
        $siswas = Siswa::where('nama', 'like', "%{$this->search}%")
            ->orderBy('nama')
            ->paginate(10);

        // Ambil nilai siswa sesuai mapel terpilih
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